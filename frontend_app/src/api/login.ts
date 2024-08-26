import axios from "axios";

export const login = async ({
  email,
  password,
}: {
  email: string,
  password: string,
}) => {
  try {
    const { data } = await axios.post('/login', {
      email,
      password,
    });

    localStorage.setItem('@auth', `${data.token}`);

    return data.user;
  } catch (err) {
    console.log(err);
  }
};