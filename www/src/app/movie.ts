import { Genre } from './genre';

export class Movie {

  id: number;
  imdbId: string;
  title: string;
  year: number;
  genres: Genre[];

}
