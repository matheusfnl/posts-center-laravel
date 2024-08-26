import type Post from "@/interfaces/post";
import axios from "axios";

export const createPost = async ({
  title,
  description,
}: {
  title: string,
  description: string,
}): Promise<Post | null> => {
  try {
    const { data } = await axios.post('/posts', {
      title,
      description,
    });

    return data;
  } catch (err) {
    console.log(err);

    return null;
  }
};