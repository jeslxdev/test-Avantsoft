import api from '../api';

const login = async (email, password) => {
  try {
    const { data } = await api.post('/login', { email, password });
    localStorage.setItem('user', JSON.stringify({ email, token: data.token }));
    return { success: true, token: data.token };
  } catch (error) {
    return { success: false, error: 'Credenciais inválidas' };
  }
};

const logout = () => {
  localStorage.removeItem('user');
};

const getUser = () => {
  return JSON.parse(localStorage.getItem('user'));
};

const getToken = () => {
  const user = getUser();
  return user ? user.token : null;
};

const authService = { login, logout, getUser, getToken };
export default authService;
