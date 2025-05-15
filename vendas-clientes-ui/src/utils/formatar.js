export function formatarDataBR(data) {
  if (!data) return '';
  // Corrige fuso horário para evitar subtração de 1 dia
  const d = new Date(data + 'T00:00:00');
  if (isNaN(d)) return data;
  return d.toLocaleDateString('pt-BR');
}

export function formatarNumero(n) {
  if (n === null || n === undefined || isNaN(n)) return '-';
  return Number(n).toLocaleString('pt-BR');
}

export function formatarReal(valor) {
  if (valor === null || valor === undefined || isNaN(valor)) return 'R$ 0,00';
  return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}
