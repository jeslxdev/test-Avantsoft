import React, { useEffect, useState } from 'react';
import Login from './components/Login';
import './App.css';
import ClienteForm from './components/ClienteForm';
import ClienteLista from './components/ClienteLista';
import GraficoVendas from './components/GraficoVendas';
import api from './api';
import { normalizarClientes } from './utils/normalizarClientes';
import 'bootstrap/dist/css/bootstrap.min.css';

function getDestaques(clientes) {
  if (!clientes.length) return {};
  let maiorVolume = clientes[0];
  let maiorMedia = clientes[0];
  let maiorFrequencia = clientes[0];
  let maxVendas = 0;
  let maxMedia = 0;
  let maxFreq = 0;
  clientes.forEach(c => {
    const vendas = c.vendas || [];
    if (vendas.length > maxVendas) {
      maxVendas = vendas.length;
      maiorVolume = c;
    }
    const media = vendas.length ? vendas.reduce((a, v) => a + v.valor, 0) / vendas.length : 0;
    if (media > maxMedia) {
      maxMedia = media;
      maiorMedia = c;
    }
    const freq = vendas.reduce((acc, v) => {
      acc[v.data] = (acc[v.data] || 0) + 1;
      return acc;
    }, {});
    const maxF = Math.max(...Object.values(freq), 0);
    if (maxF > maxFreq) {
      maxFreq = maxF;
      maiorFrequencia = c;
    }
  });
  
  const destaques = {};
  if (maiorVolume.nome) destaques[maiorVolume.nome] = 'volume';
  if (maiorMedia.nome) destaques[maiorMedia.nome] = 'media';
  if (maiorFrequencia.nome) destaques[maiorFrequencia.nome] = 'frequencia';
  return destaques;
}

function Dashboard({ clientes, vendasPorDia }) {
  const destaques = getDestaques(clientes);
  return (
    <div className="dashboard" style={{maxWidth:600,margin:'32px auto',background:'#fff',borderRadius:12,boxShadow:'0 2px 8px #0001',padding:24}}>
      <h2 style={{color:'#2196F3',marginBottom:24}}>Dashboard</h2>
      <div className="chart-container" style={{marginBottom:32}}>
        <GraficoVendas clientes={clientes} destaques={destaques} />
      </div>
    </div>
  );
}

export default function App() {
  const [clientes, setClientes] = useState([]);
  const [vendasPorDia, setVendasPorDia] = useState({});
  const [auth, setAuth] = useState(() => {
    const token = localStorage.getItem('token');
    return token ? { isAuthenticated: true, token } : { isAuthenticated: false };
  });
  const [loginError, setLoginError] = useState('');
  const [view, setView] = useState('dashboard');
  const [lastActivity, setLastActivity] = useState(Date.now());

  useEffect(() => {
    const checkTimeout = () => {
      const token = localStorage.getItem('token');
      if (auth.isAuthenticated && token) {
        const now = Date.now();
        if (now - lastActivity > 30 * 60 * 1000) {
          setAuth({ isAuthenticated: false });
          localStorage.removeItem('token');
          sessionStorage.removeItem('token');
        }
      }
    };
    const interval = setInterval(checkTimeout, 60 * 1000);
    return () => clearInterval(interval);
  }, [auth.isAuthenticated, lastActivity]);

  useEffect(() => {
    const updateActivity = () => setLastActivity(Date.now());
    window.addEventListener('mousemove', updateActivity);
    window.addEventListener('keydown', updateActivity);
    window.addEventListener('click', updateActivity);
    return () => {
      window.removeEventListener('mousemove', updateActivity);
      window.removeEventListener('keydown', updateActivity);
      window.removeEventListener('click', updateActivity);
    };
  }, []);

  const handleLogin = async (email, password) => {
    try {
      const { data } = await api.post('/login', { email, password });
      sessionStorage.setItem('token', data.token);
      localStorage.setItem('token', data.token);
      setAuth({ isAuthenticated: true, token: data.token });
      setLoginError('');
    } catch {
      setLoginError('Credenciais inválidas');
    }
  };

  const fetchClientes = async () => {
    try {
      const token = localStorage.getItem('token') || sessionStorage.getItem('token');
      const { data } = await api.get('/clientes', { headers: { Authorization: `Bearer ${token}` } });
      const normalizados = normalizarClientes(data);
      setClientes(normalizados);
    } catch {
      setClientes([]);
    }
  };

  const fetchEstatisticas = async () => {
    try {
      const token = localStorage.getItem('token') || sessionStorage.getItem('token');
      const { data } = await api.get('/sales/total-por-dia', { headers: { Authorization: `Bearer ${token}` } });
      setVendasPorDia(data || {});
    } catch {
      setVendasPorDia({});
    }
  };

  useEffect(() => {
    if (auth.isAuthenticated) {
      fetchClientes();
      fetchEstatisticas();
    }
  }, [auth]);

  const handleCadastrarCliente = async (cliente) => {
    try {
      const token = localStorage.getItem('token') || sessionStorage.getItem('token');
      await api.post('/clientes', cliente, { headers: { Authorization: `Bearer ${token}` } });
      fetchClientes();
    } catch {
      alert('Erro ao cadastrar cliente');
    }
  };

  if (!auth.isAuthenticated) {
    return <Login onLogin={handleLogin} error={loginError} />;
  }

  return (
    <div className="app-container" style={{paddingTop:70}}>
      <nav className="main-nav navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top" style={{zIndex:100}}>
        <div className="container-fluid nav-content" style={{maxWidth:1200}}>
          <div className="nav-logo navbar-brand" style={{color:'#2196F3',fontWeight:'bold',fontSize:'1.5rem'}}>Gestão Clientes</div>
          <div className="nav-buttons d-flex gap-2">
            <button onClick={() => setView('dashboard')} className={`btn ${view==='dashboard' ? 'btn-primary' : 'btn-outline-primary'}`}>Dashboard</button>
            <button onClick={() => setView('cadastro')} className={`btn ${view==='cadastro' ? 'btn-success' : 'btn-outline-success'}`}>Cadastrar Cliente</button>
            {/* <button onClick={() => setView('venda')} className={`btn ${view==='venda' ? 'btn-warning' : 'btn-outline-warning'}`}>Cadastrar Venda</button> */}
            <button onClick={() => setView('crud')} className={`btn ${view==='crud' ? 'btn-dark' : 'btn-outline-dark'}`}>CRUD Clientes</button>
            <button onClick={() => { setAuth({ isAuthenticated: false }); localStorage.removeItem('token'); sessionStorage.removeItem('token'); }} className="btn btn-outline-danger">Sair</button>
          </div>
        </div>
      </nav>
      <main className="main-content container-fluid" style={{marginTop:32}}>
        {view === 'dashboard' && (
          <Dashboard clientes={clientes} vendasPorDia={vendasPorDia} />
        )}
        {view === 'cadastro' && (
          <div className="dashboard row justify-content-center">
            <div className="col-12 col-md-8 col-lg-6">
              <h2 className="mb-4">Cadastrar Cliente</h2>
              <ClienteForm onAdd={handleCadastrarCliente} />
            </div>
          </div>
        )}
        {/* {view === 'venda' && (
          <div className="dashboard row justify-content-center">
            <div className="col-12 col-md-8 col-lg-6">
              <VendaForm />
            </div>
          </div>
        )} */}
        {view === 'crud' && (
          <div className="dashboard row justify-content-center">
            <div className="col-12 col-lg-10">
              <h2 className="mb-4">CRUD de Clientes</h2>
              <ClienteLista />
            </div>
          </div>
        )}
      </main>
    </div>
  );
}
