import React, { useEffect, useState } from 'react';
import clientService from '../services/clientService';
import Graph from '../components/Graph';

const Dashboard = () => {
  const [clientes, setClientes] = useState([]);
  const [estatisticas, setEstatisticas] = useState({});
  const [vendasPorDia, setVendasPorDia] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      const clientesData = await clientService.getClientes();
      setClientes(clientesData);

      const estatisticasData = await clientService.getEstatisticas();
      setEstatisticas(estatisticasData);
      setVendasPorDia(estatisticasData.vendasPorDia || []);
    };

    fetchData();
  }, []);

  const clienteMaiorVolumeVendas = clientes.reduce((prev, curr) => (curr.vendas.length > prev.vendas.length ? curr : prev), {});
  const clienteMaiorMediaVendas = clientes.reduce((prev, curr) => {
    const mediaPrev = prev.vendas.reduce((acc, v) => acc + v.valor, 0) / prev.vendas.length;
    const mediaCurr = curr.vendas.reduce((acc, v) => acc + v.valor, 0) / curr.vendas.length;
    return mediaCurr > mediaPrev ? curr : prev;
  }, { vendas: [] });
  
  return (
    <div>
      <h2>Dashboassrd</h2>
      <Graph vendasPorDia={vendasPorDia} />
      <h3>Cliente com Maior Volume de Vendas: {clienteMaiorVolumeVendas.nome}</h3>
      <h3>Cliente com Maior Média de Vendas: {clienteMaiorMediaVendas.nome}</h3>
      {/* Adicionar lógica para maior frequência de compras e outras estatísticas */}
    </div>
  );
};

export default Dashboard;
