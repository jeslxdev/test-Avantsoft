import React, { useEffect, useState } from 'react';
import { Line } from 'react-chartjs-2';
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale);

const Graph = ({ vendasPorDia }) => {
  const [data, setData] = useState({});

  useEffect(() => {
    const labels = vendasPorDia.map((venda) => venda.data);
    const valores = vendasPorDia.map((venda) => venda.valor);

    setData({
      labels,
      datasets: [
        {
          label: 'Total de Vendas por Dia',
          data: valores,
          borderColor: 'rgba(75, 192, 192, 1)',
          fill: false,
        },
      ],
    });
  }, [vendasPorDia]);

  return <Line data={data} />;
};

export default Graph;
