import axios from "axios";

export const logout = async () => {
  try {
    await axios.post('/logout');

    localStorage.setItem('@auth', '');
  } catch (err) {
    console.log(err);
  }
};