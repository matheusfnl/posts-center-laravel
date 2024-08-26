import axios from "axios";

export const getUser = async () => {
  try {
    const { data } = await axios.get('/user');

    return data;
  } catch (err) {
    console.log(err);
  }
};