import axios from "axios";

export const createVote = async ({ id, vote_type }: { id: number|string, vote_type: string }) => {
  try {
    const { data } = await axios.post(`/posts/${id}/votes`, { vote_type });

    return data;
  } catch (err) {
    console.log(err);
  }
};