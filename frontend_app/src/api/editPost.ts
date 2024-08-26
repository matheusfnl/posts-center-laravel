import type Post from "@/interfaces/post";
import axios from "axios";

export const editPost = async ({
  title,
  description,
  id,
}: {
  title: string,
  description: string,
  id: number,
}): Promise<Post | null> => {
  try {
    const { data } = await axios.put(`/posts/${id}`, {
      title,
      description,
    });

    return data;
  } catch (err) {
    console.log(err);

    return null;
  }
};