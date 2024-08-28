import axios from "axios";

export const deletePostComment = async ({ id, comment_id }: {
  id: number|string,
  comment_id: number|string,
}) => {
  try {
    await axios.delete(`/posts/${id}/comments/${comment_id}`);
  } catch (err) {
    console.log(err);
  }
};