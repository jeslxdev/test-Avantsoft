import React from 'react';
import { formatarReal, formatarNumero } from '../utils/formatar';

export default function GraficoVendas({ clientes }) {
  const vendasPorDia = {};
  clientes.forEach(cliente => {
    cliente.vendas.forEach(v => {
      vendasPorDia[v.data] = (vendasPorDia[v.data] || 0) + v.valor;
    });
  });

  let maiorVolume = { nome: '', total: 0 };
  let maiorMedia = { nome: '', media: 0 };
  let maiorFrequencia = { nome: '', freq: 0 };
  clientes.forEach(cliente => {
    const total = cliente.vendas.reduce((a, v) => a + v.valor, 0);
    if (total > maiorVolume.total) maiorVolume = { nome: cliente.nome, total };
    const media = cliente.vendas.length ? total / cliente.vendas.length : 0;
    if (media > maiorMedia.media) maiorMedia = { nome: cliente.nome, media };
    const freq = Math.max(...Object.values(cliente.vendas.reduce((acc, v) => { acc[v.data] = (acc[v.data] || 0) + 1; return acc; }, {})), 0);
    if (freq > maiorFrequencia.freq) maiorFrequencia = { nome: cliente.nome, freq };
  });

  const totalGeral = Object.values(vendasPorDia).reduce((a, b) => a + b, 0);

  const cards = [
    {
      label: 'Total de Vendas',
      value: formatarReal(totalGeral),
      border: '#222',
    },
    {
      label: 'Maior Volume de Vendas',
      value: `${maiorVolume.nome || '-'} (${formatarReal(maiorVolume.total)})`,
      border: '#388e3c',
    },
    {
      label: 'Maior Média por Venda',
      value: `${maiorMedia.nome || '-'} (${formatarReal(maiorMedia.media)})`,
      border: '#fbc02d',
    },
    {
      label: 'Maior Frequência de Compras',
      value: `${maiorFrequencia.nome || '-'} (${formatarNumero(maiorFrequencia.freq)})`,
      border: '#d32f2f',
    },
  ];

  return (
    <div style={{
      display: 'grid',
      gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))',
      gap: 24,
      justifyContent: 'center',
      alignItems: 'stretch',
      width: '100%',
      margin: '0 auto',
      maxWidth: 900
    }}>
      {cards.map((card, i) => (
        <div key={i} style={{
          border: `3px solid ${card.border}`,
          background: 'rgba(255,255,255,0.95)',
          borderRadius: 16,
          minHeight: 120,
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          justifyContent: 'center',
          boxShadow: '0 2px 8px #0001',
          fontWeight: 'bold',
          fontSize: 18,
          transition: 'box-shadow 0.2s',
        }}>
          <div style={{fontSize: 16, color: card.border, marginBottom: 8, textAlign:'center'}}>{card.label}</div>
          <div style={{fontSize: 28, color: '#222', textAlign:'center'}}>{card.value}</div>
        </div>
      ))}
    </div>
  );
}
