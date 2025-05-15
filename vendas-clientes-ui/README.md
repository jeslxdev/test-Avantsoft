# Vendas Clientes UI

Sistema de gestão de clientes e vendas (frontend).

## Stacks utilizadas
- React 18 (Create React App)
- Bootstrap 5
- Axios
- JavaScript ES6+
- Consome API RESTful (Laravel backend)

## Como rodar o projeto

1. **Clone o repositório:**

   ```bash
   git clone <url-do-repo>
   cd vendas-clientes-ui
   ```

2. **Instale as dependências:**

   ```bash
   npm install
   ```

3. **Configure o endpoint da API:**

   - O frontend espera que o backend Laravel esteja rodando em um IP acessível.
   - Altere a baseURL em `src/api.js` para o IP/porta do seu backend, por exemplo:
     ```js
     // src/api.js
     import axios from 'axios';
     export default axios.create({
       baseURL: 'http://SEU_IP_BACKEND:8000/api',
     });
     ```

4. **Rode o projeto:**

   ```bash
   npm start
   ```

   O app estará disponível em [http://localhost:3000](http://localhost:3000)

## Observações
- O backend deve ser um projeto Laravel com autenticação JWT e os endpoints documentados.
- O frontend é responsivo e utiliza Bootstrap para layout.
- Para login, use as credenciais cadastradas no backend.

---

Dúvidas? Abra uma issue ou entre em contato.

We suggest that you begin by typing:

  cd vendas-clientes-ui
  npm start

Happy hacking!
