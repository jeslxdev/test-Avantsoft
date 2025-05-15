import React, { useState } from 'react';
import api from '../api';

export default function ClienteForm({ onAdd }) {
  const [form, setForm] = useState({
    nome: '',
    razao_social: '',
    nome_fantasia: '',
    email: '',
    cpfCnpj: '',
    telefone: '',
    endereco: '',
    cidade: '',
    estado: '',
    cep: '',
    pais: '',
    tipo_cliente: '',
    data_nascimento: '',
  });

  const handleChange = e => setForm({ ...form, [e.target.name]: e.target.value });

  const handleSubmit = async e => {
    e.preventDefault();
    try {
      const token = localStorage.getItem('token') || sessionStorage.getItem('token');
      const response = await api.post('/clientes', form, { headers: { Authorization: `Bearer ${token}` } });
      onAdd(response.data);
      setForm({
        nome: '', razao_social: '', nome_fantasia: '', email: '', cpfCnpj: '', telefone: '', endereco: '', cidade: '', estado: '', cep: '', pais: '', tipo_cliente: '', data_nascimento: ''
      });
    } catch (err) {
      alert('Erro ao adicionar cliente');
    }
  };

  return (
    <form onSubmit={handleSubmit} className="form-container">
      <h4>Dados do Cliente</h4>
      <div className="form-row">
        <input name="nome" value={form.nome} onChange={handleChange} placeholder="Nome" required className="form-control" />
        <input name="razao_social" value={form.razao_social} onChange={handleChange} placeholder="Razão Social" className="form-control" />
      </div>
      <div className="form-row">
        <input name="email" type="email" value={form.email} onChange={handleChange} placeholder="Email" required className="form-control" />
        <input name="cpfCnpj" value={form.cpfCnpj} onChange={handleChange} placeholder="CPF/CNPJ" className="form-control" />
      </div>
      <div className="form-row">
        <input name="telefone" value={form.telefone} onChange={handleChange} placeholder="Telefone" className="form-control" />
        <input name="endereco" value={form.endereco} onChange={handleChange} placeholder="Endereço" className="form-control" />
      </div>
      <div className="form-row">
        <input name="cidade" value={form.cidade} onChange={handleChange} placeholder="Cidade" className="form-control" />
        <input name="estado" value={form.estado} onChange={handleChange} placeholder="Estado" className="form-control" />
      </div>
      <div className="form-row">
        <input name="cep" value={form.cep} onChange={handleChange} placeholder="CEP" className="form-control" />
        <input name="pais" value={form.pais} onChange={handleChange} placeholder="País" className="form-control" />
      </div>
      <div className="form-row">
        <input name="tipo_cliente" value={form.tipo_cliente} onChange={handleChange} placeholder="Tipo de Cliente" className="form-control" />
        <input name="data_nascimento" type="date" value={form.data_nascimento} onChange={handleChange} placeholder="Data de Nascimento" className="form-control" />
      </div>
      <button type="submit" className="btn btn-primary">Salvar Cliente</button>
    </form>
  );
}
