export function normalizarClientes(dados) {
  return (dados?.data?.clientes || []).map(cliente => {
    const nome = cliente.info?.nomeCompleto || cliente.duplicado?.nomeCompleto || '';
    const email = cliente.info?.detalhes?.email || '';
    const nascimento = cliente.info?.detalhes?.nascimento || '';
    const vendas = cliente.estatisticas?.vendas || [];

    return { nome, email, nascimento, vendas, ...cliente };
  });
}
