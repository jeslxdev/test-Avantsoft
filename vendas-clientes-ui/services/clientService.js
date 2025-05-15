import axios from 'axios';

const getClientes = async () => {
  try {
    const response = await axios.get('/api/clientes'); 
    const clientes = response.data.data.clientes.map((cliente) => ({
      nome: cliente.info.nomeCompleto,
      email: cliente.info.detalhes.email,
      nascimento: cliente.info.detalhes.nascimento,
      vendas: cliente.estatisticas.vendas || [],
    }));
    return clientes;
  } catch (error) {
    console.error('Erro ao obter clientes:', error);
    return [];
  }
};

const getEstatisticas = async () => {
  try {
    const response = await axios.get('/api/estatisticas');
    return response.data;
  } catch (error) {
    console.error('Erro ao obter estatísticas:', error);
    return {};
  }
};

export default { getClientes, getEstatisticas };
