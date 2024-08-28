import axios from "axios";

export const editVote = async ({ id, vote_id, vote_type }: {
  id: number|string,
  vote_id: number|string,
  vote_type: string,
}) => {
  try {
    const { data } = await axios.put(`/posts/${id}/votes/${vote_id}`, { vote_type });

    return data;
  } catch (err) {
    console.log(err);
  }
};