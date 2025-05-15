const login = (email, password) => {
  if (email === 'admin@example.com' && password === 'password') {
    localStorage.setItem('user', JSON.stringify({ email }));
    return true;
  }
  return false;
};

const logout = () => {
  localStorage.removeItem('user');
};

const getUser = () => {
  return JSON.parse(localStorage.getItem('user'));
};

export default { login, logout, getUser };
