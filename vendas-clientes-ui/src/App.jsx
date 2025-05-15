import { useEffect, useState } from 'react';
import ClienteForm from './components/ClienteForm';
import ClienteLista from './components/ClienteLista';
import GraficoVendas from './components/GraficoVendas';
import api from 'api';
import { normalizarClientes } from './utils/normalizarClientes';

function App() {
  const [clientes, setClientes] = useState([]);

  useEffect(() => {
    async function fetchClientes() {
      try {
        const res = await api.get('/clientes');
        const normalizados = normalizarClientes(res.data);
        setClientes(normalizados);
      } catch {
        alert('Erro ao carregar clientes');
      }
    }

    fetchClientes();
  }, []);

  const adicionarCliente = cliente => setClientes(prev => [...prev, cliente]);

  return (
    <div>
      <h1>Gestão de Clientes</h1>
      <ClienteForm onAdd={adicionarCliente} />
      <GraficoVendas clientes={clientes} />
      <ClienteLista clientes={clientes} />
    </div>
  );
}

export default App;
