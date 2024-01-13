export const useMyFetch =  (path) => {
    const api = 'http://localhost:8000'
    return useFetch(() => `${api}/${path}`);
}
