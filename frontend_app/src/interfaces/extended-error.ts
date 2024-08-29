export default interface ExtendedError extends Error {
  response?: { data?: { errors?: Record<string, any>; }; };
}
