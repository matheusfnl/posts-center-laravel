import axios from "axios";

export const createPostComments = async ({ id, description }: { id: number|string, description: string }) => {
  try {
    const { data } = await axios.post(`/posts/${id}/comments`, { description });

    return data;
  } catch (err) {
    console.log(err);
  }
};