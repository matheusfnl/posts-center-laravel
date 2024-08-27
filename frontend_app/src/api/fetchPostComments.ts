import axios from "axios";

export const fetchPostComments = async ({ id, page }: { id: number|string, page: number }) => {
  try {
    const params = new URLSearchParams({ page: `${page}` });

    const { data } = await axios.get(`/posts/${id}/comments`, { params });

    return data;
  } catch (err) {
    console.log(err);
  }
};