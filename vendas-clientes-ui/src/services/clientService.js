import api from '../api';

const getToken = () => localStorage.getItem('token') || sessionStorage.getItem('token');

const getClientes = async () => {
  try {
    const token = getToken();
    const response = await api.get('/clientes', {
      headers: { Authorization: `Bearer ${token}` }
    });
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
    const token = getToken();
    const response = await api.get('/estatisticas', {
      headers: { Authorization: `Bearer ${token}` }
    });
    return response.data;
  } catch (error) {
    console.error('Erro ao obter estatísticas:', error);
    return {};
  }
};

const cadastrarCliente = async (cliente) => {
  try {
    const token = getToken();
    const response = await api.post('/clientes', cliente, {
      headers: { Authorization: `Bearer ${token}` }
    });
    return response.data;
  } catch (error) {
    throw error;
  }
};

export default { getClientes, getEstatisticas, cadastrarCliente };
