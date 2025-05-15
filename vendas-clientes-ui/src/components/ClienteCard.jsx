import React from 'react';
import { formatarDataBR, formatarReal } from '../utils/formatar';

export default function ClienteCard({ cliente, destaque }) {
  const totalVendas = cliente.vendas.reduce((sum, v) => sum + v.valor, 0);
  const media = cliente.vendas.length ? (totalVendas / cliente.vendas.length) : 0;

  return (
    <div style={{ border: destaque ? '2px solid #4CAF50' : '1px solid #ccc', margin: '16px auto', padding: 16, background: destaque ? '#e8f5e9' : '#fff', borderRadius: 10, maxWidth: 400, boxShadow: '0 2px 8px #0001' }}>
      <h3 style={{margin:'0 0 8px 0',color:'#2196F3'}}>{cliente.nome}</h3>
      <div style={{fontSize:15,marginBottom:8}}><strong>Email:</strong> {cliente.email}</div>
      <div style={{fontSize:15,marginBottom:8}}><strong>Nascimento:</strong> {formatarDataBR(cliente.data_nascimento || cliente.nascimento)}</div>
      <div style={{fontSize:15,marginBottom:8}}><strong>Total de Vendas:</strong> {formatarReal(totalVendas)}</div>
      <div style={{fontSize:15,marginBottom:8}}><strong>Média por Venda:</strong> {formatarReal(media)}</div>
    </div>
  );
}
