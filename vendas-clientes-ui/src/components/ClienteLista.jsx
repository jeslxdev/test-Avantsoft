import ClienteCard from './ClienteCard';
import React, { useState, useEffect, useRef } from 'react';
import { normalizarClientes } from '../utils/normalizarClientes';
import api from '../api';
import { formatarDataBR, formatarReal } from '../utils/formatar';

export default function ClienteLista() {
  const [search, setSearch] = useState('');
  const [campo, setCampo] = useState('nome');
  const [clientes, setClientes] = useState([]);
  const [loading, setLoading] = useState(false);
  const [editando, setEditando] = useState(null);
  const [form, setForm] = useState({});
  const [autocomplete, setAutocomplete] = useState([]);
  const [clienteSelecionado, setClienteSelecionado] = useState(null);
  const [pagina, setPagina] = useState(1);
  const itensPorPagina = 10;
  const inputRef = useRef();

  useEffect(() => {
    handleBuscar();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  useEffect(() => {
    if (!search) {
      setClienteSelecionado(null);
    }
    if (search.length > 0) {
      (async () => {
        const token = localStorage.getItem('token') || sessionStorage.getItem('token');
        let params = {};
        if (campo === 'nome' || campo === 'email' || campo === 'cpfCnpj') {
          params[campo] = search;
        }
        const { data } = await api.get('/clientes', {
          headers: { Authorization: `Bearer ${token}` },
          params
        });
        const normalizados = normalizarClientes({ data: { clientes: data.data ? data.data.clientes : data } });
        setAutocomplete(
          normalizados.filter(c => {
            const valor = (c[campo] || '').toLowerCase();
            return valor.startsWith(search.toLowerCase()) && valor !== search.toLowerCase();
          }).slice(0, 5)
        );
      })();
    } else {
      setAutocomplete([]);
    }
  }, [search, campo]);

  const handleBuscar = async () => {
    setLoading(true);
    try {
      const token = localStorage.getItem('token') || sessionStorage.getItem('token');
      let params = {};
      if (search && (campo === 'nome' || campo === 'email' || campo === 'cpfCnpj')) {
        params[campo] = search;
      }
      const { data } = await api.get('/clientes', {
        headers: { Authorization: `Bearer ${token}` },
        params
      });
      const normalizados = normalizarClientes({ data: { clientes: data.data ? data.data.clientes : data } });
      setClientes(normalizados);
      if (search && normalizados.length === 1) {
        setClienteSelecionado(normalizados[0]);
      } else {
        setClienteSelecionado(null);
      }
    } finally {
      setLoading(false);
    }
  };

  const handleKeyDown = e => {
    if (e.key === 'Enter') handleBuscar();
  };

  const handleEdit = cliente => {
    setEditando(cliente.id);
    setForm({
      id: cliente.id,
      nome: cliente.nome || '',
      email: cliente.email || '',
      data_nascimento: cliente.data_nascimento || cliente.nascimento || ''
    });
    setClienteSelecionado(null);
  };

  const handleDelete = async (cliente) => {
    if (!window.confirm('Tem certeza que deseja excluir este cliente?')) return;
    const token = localStorage.getItem('token') || sessionStorage.getItem('token');
    await api.delete(`/clientes/${cliente.id}`, { headers: { Authorization: `Bearer ${token}` } });
    handleBuscar();
    setClienteSelecionado(null);
  };

  const handleEditSubmit = async e => {
    e.preventDefault();
    const token = localStorage.getItem('token') || sessionStorage.getItem('token');
    const patchData = {};
    if (form.nome !== undefined) patchData.nome = form.nome;
    if (form.email !== undefined) patchData.email = form.email;
    if (form.data_nascimento !== undefined) patchData.data_nascimento = form.data_nascimento;
    await api.patch(`/clientes/${form.id || editando}`, patchData, { headers: { Authorization: `Bearer ${token}` } });
    setEditando(null);
    handleBuscar();
  };

  const handleSelectCliente = cliente => {
    setClienteSelecionado(cliente);
    setEditando(null);
    setAutocomplete([]);
    setSearch(cliente[campo] || cliente.nome);
    setClientes([cliente]);
  };

  const campos = [
    { value: 'nome', label: 'Nome' },
    { value: 'email', label: 'Email' },
    { value: 'cpfCnpj', label: 'CPF/CNPJ' },
    { value: 'cidade', label: 'Cidade' },
    { value: 'estado', label: 'Estado' },
    { value: 'tipo_cliente', label: 'Tipo Cliente' },
  ];


  const clientesPaginados = clientes.slice((pagina-1)*itensPorPagina, pagina*itensPorPagina);
  const totalPaginas = Math.ceil(clientes.length / itensPorPagina);

  return (
    <div className="container-fluid" style={{maxWidth:900,margin:'0 auto',background:'#fff',borderRadius:12,boxShadow:'0 2px 8px #0001',padding:24}}>
      <div className="row g-3 align-items-center mb-4" style={{background:'#f4f7f6', borderRadius:8, padding:16}}>
        <div className="col-12 col-md-2">
          <select value={campo} onChange={e => setCampo(e.target.value)} className="form-select">
            {campos.map(c => <option key={c.value} value={c.value}>{c.label}</option>)}
          </select>
        </div>
        <div className="col-12 col-md-5 position-relative">
          <input
            ref={inputRef}
            type="text"
            placeholder="Pesquisar..."
            value={search}
            onChange={e => setSearch(e.target.value)}
            onKeyDown={handleKeyDown}
            className="form-control"
            autoComplete="off"
          />
          {autocomplete.length > 0 && (
            <div style={{position:'absolute',top:'100%',left:0,right:0, background:'#fff', border:'1px solid #ccc', zIndex:10, borderRadius:6, boxShadow:'0 2px 8px #0002'}}>
              {autocomplete.map((c, i) => (
                <div key={i} style={{padding:10, cursor:'pointer',fontSize:15}} onClick={() => handleSelectCliente(c)}>{c.nome}</div>
              ))}
            </div>
          )}
        </div>
        <div className="col-12 col-md-3 d-grid">
          <button onClick={handleBuscar} disabled={loading} className="btn btn-primary fw-bold" style={{padding:'10px 18px',fontSize:15}}>
            {loading ? 'Buscando...' : 'Buscar'}
          </button>
        </div>
      </div>
        {clienteSelecionado && (
            <div className="mt-4">
            <ClienteCard cliente={clienteSelecionado} />
            </div>
        )}
      <div className="table-responsive">
        <table className="table table-bordered table-hover align-middle" style={{background:'#fff', borderRadius:8, boxShadow:'0 2px 8px #0001', marginBottom:16, fontSize:15}}>
          <thead className="table-light">
            <tr>
              <th>Nome</th>
              <th>Email</th>
              <th>Nascimento</th>
              <th>Total Vendas</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            {clientesPaginados.length === 0 ? (
              <tr><td colSpan={5} className="text-center py-3">Nenhum cliente encontrado.</td></tr>
            ) : (
              clientesPaginados.map(cliente => editando === cliente.id ? (
                <tr key={cliente.id} style={{background:'#e3f2fd'}}>
                  <td><input value={form.nome} onChange={e=>setForm(f=>({...f,nome:e.target.value}))} className="form-control" /></td>
                  <td><input value={form.email} onChange={e=>setForm(f=>({...f,email:e.target.value}))} className="form-control" /></td>
                  <td><input value={form.data_nascimento || form.nascimento} onChange={e=>setForm(f=>({...f,data_nascimento:e.target.value,nascimento:e.target.value}))} type="date" className="form-control" /></td>
                  <td>-</td>
                  <td>
                    <button onClick={handleEditSubmit} className="btn btn-success btn-sm me-2">Salvar</button>
                    <button onClick={()=>setEditando(null)} className="btn btn-secondary btn-sm">Cancelar</button>
                  </td>
                </tr>
              ) : (
                <tr key={cliente.id}>
                  <td>{cliente.nome}</td>
                  <td>{cliente.email}</td>
                  <td>{formatarDataBR(cliente.nascimento || cliente.data_nascimento)}</td>
                  <td>{formatarReal(cliente.vendas?.reduce((a,v)=>a+v.valor,0))}</td>
                  <td>
                    <button title="Editar" onClick={()=>handleEdit(cliente)} className="btn btn-primary btn-sm me-2">✏️</button>
                    <button title="Excluir" onClick={()=>handleDelete(cliente)} className="btn btn-danger btn-sm">🗑️</button>
                  </td>
                </tr>
              ))
            )}
          </tbody>
        </table>
      </div>
      {totalPaginas > 1 && (
        <div className="d-flex justify-content-center align-items-center gap-2 mb-3">
          <button onClick={()=>setPagina(p=>Math.max(1,p-1))} disabled={pagina===1} className="btn btn-outline-secondary">Anterior</button>
          <span>Página {pagina} de {totalPaginas}</span>
          <button onClick={()=>setPagina(p=>Math.min(totalPaginas,p+1))} disabled={pagina===totalPaginas} className="btn btn-outline-secondary">Próxima</button>
        </div>
      )}
    </div>
  );
}