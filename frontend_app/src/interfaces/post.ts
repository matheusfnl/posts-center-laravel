import type Vote from '@/interfaces/vote';

export default interface Post {
  created_at: string,
  description: string,
  downvotes_qtd?: number,
  id: number,
  title: string,
  updated_at: string,
  upvotes_qtd?: number,
  user_id: number,
  vote?: Vote,
  comments_qtd?: number,
}
