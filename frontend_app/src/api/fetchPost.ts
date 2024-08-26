import axios from "axios";

export const fetchPost = async ({ id }: { id: number|string }) => {
  try {
    const { data } = await axios.get(`/posts/${id}`);

    return data;
  } catch (err) {
    console.log(err);
  }
};