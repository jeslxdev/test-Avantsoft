import React, { useState } from 'react';
import api from '../api';
import { normalizarClientes } from '../utils/normalizarClientes';

export default function VendaForm() {
  const [cpfCnpj, setCpfCnpj] = useState('');
  const [cliente, setCliente] = useState(null);
  const [venda, setVenda] = useState({
    data_venda: '',
    valor: '',
    parcelada: '',
    metodo_pagamento: '',
    status_venda: '',
    status_pagamento: '',
  });
  const [buscando, setBuscando] = useState(false);
  const [msg, setMsg] = useState('');

  const buscarCliente = async () => {
    setBuscando(true);
    setMsg('');
    try {
      const token = localStorage.getItem('token') || sessionStorage.getItem('token');
      const { data } = await api.get('/clientes', {
        headers: { Authorization: `Bearer ${token}` },
        params: { cpfCnpj }
      });
      const normalizados = normalizarClientes({ data: { clientes: data.data ? data.data.clientes : data } });
      setCliente(normalizados[0] || null);
      if (!normalizados[0]) setMsg('Cliente não encontrado.');
    } finally {
      setBuscando(false);
    }
  };

  const handleVendaChange = e => setVenda({ ...venda, [e.target.name]: e.target.value });

  const handleSubmit = async e => {
    e.preventDefault();
    if (!cliente) return setMsg('Selecione um cliente válido.');
    try {
      const token = localStorage.getItem('token') || sessionStorage.getItem('token');
      await api.post('/sales', { ...venda, cliente_id: cliente.id }, { headers: { Authorization: `Bearer ${token}` } });
      setMsg('Venda cadastrada com sucesso!');
      setVenda({ data_venda: '', valor: '', parcelada: '', metodo_pagamento: '', status_venda: '', status_pagamento: '' });
    } catch {
      setMsg('Erro ao cadastrar venda.');
    }
  };

  return (
    <div className="venda-form-container">
      <h2>Cadastrar Venda</h2>
      <form onSubmit={handleSubmit} className="form-container">
        <div className="form-row">
          <input
            name="cpfCnpj"
            value={cpfCnpj}
            onChange={e => setCpfCnpj(e.target.value)}
            placeholder="CPF/CNPJ do Cliente"
            required
            style={{flex:1}}
          />
          <button type="button" onClick={buscarCliente} disabled={buscando} style={{marginLeft:8}}>
            {buscando ? 'Buscando...' : 'Buscar Cliente'}
          </button>
        </div>
        {cliente && (
          <div className="cliente-info-box">
            <strong>Cliente:</strong> {cliente.nome} <br/>
            <span style={{fontSize:13}}>{cliente.email} | {cliente.cpfCnpj}</span>
          </div>
        )}
        <div className="form-row">
          <input name="data_venda" type="date" value={venda.data_venda} onChange={handleVendaChange} placeholder="Data da Venda" required />
          <input name="valor" type="number" value={venda.valor} onChange={handleVendaChange} placeholder="Valor" min="0" step="0.01" required />
        </div>
        <div className="form-row">
          <input name="parcelada" value={venda.parcelada} onChange={handleVendaChange} placeholder="Parcelada (S/N)" />
          <input name="metodo_pagamento" value={venda.metodo_pagamento} onChange={handleVendaChange} placeholder="Método de Pagamento" />
        </div>
        <div className="form-row">
          <input name="status_venda" value={venda.status_venda} onChange={handleVendaChange} placeholder="Status da Venda" />
          <input name="status_pagamento" value={venda.status_pagamento} onChange={handleVendaChange} placeholder="Status do Pagamento" />
        </div>
        <button type="submit" className="form-button">Cadastrar Venda</button>
        {msg && <div style={{marginTop:8, color: msg.includes('sucesso') ? 'green' : 'red'}}>{msg}</div>}
      </form>
    </div>
  );
}
