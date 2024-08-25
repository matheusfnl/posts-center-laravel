import axios from "axios";

export const fetchPosts = async ({ page, sort }: { page: number, sort: string }) => {
  try {
    const params = new URLSearchParams({ page: `${page}` });

    if (sort) {
      params.append('sort', sort);
    }

    const { data } = await axios.get('/posts', { params });

    return data;
  } catch (err) {
    console.log(err);
  }
};