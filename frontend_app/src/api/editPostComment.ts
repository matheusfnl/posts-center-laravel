import axios from "axios";

export const editPostComment = async ({ id, comment_id, description }: {
  id: number|string,
  comment_id: number|string,
  description: string,
}) => {
  try {
    const { data } = await axios.put(`/posts/${id}/comments/${comment_id}`, { description });

    return data;
  } catch (err) {
    console.log(err);
  }
};