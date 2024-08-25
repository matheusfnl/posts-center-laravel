import axios from "axios";

export const register = async ({
  name,
  email,
  password,
  confirmation_password,
}: {
  name: string,
  email: string,
  password: string,
  confirmation_password: string,
}) => {
  try {
    const { data } = await axios.post('/register', {
      name,
      email,
      password,
      confirmation_password,
    });

    localStorage.setItem('@auth', `${data.token}`);
  } catch (err) {
    console.log(err);
  }
};