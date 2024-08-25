import type Post from './post';

export default interface Resource {
  current_page: number,
  data: Post[],
  first_page_url: string,
  from: number,
  last_page: number,
  last_page_url: string,
  links: object[],
  next_page_url?: string,
  path: string,
  per_page: number,
  prev_page_url?: string,
  to: number,
  total: number,
}
