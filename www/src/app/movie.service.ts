import { Injectable } from "@angular/core";
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Observable, of } from "rxjs";
import { catchError, tap } from "rxjs/operators";
import { environment } from "../environments/environment"
import { Movie } from "./movie";

const MOVIES_URL = `${environment.baseUrl}/movies`;
const HTTP_OPTIONS = {
  headers: new HttpHeaders({
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  })
};

@Injectable({
  providedIn: "root"
})
export class MovieService {
  
  constructor(private httpClient: HttpClient) { }

  fetchMovies(): Observable<Movie[]> {
    return this.httpClient
      .get<Movie[]>(MOVIES_URL, HTTP_OPTIONS)
      .pipe(
        tap(movies => console.log(`Fetched [${movies.length}] movies`)),
        catchError(this.onError<Movie[]>("fetchMovies", []))
      );
  }

  fetchMovie(id: number): Observable<Movie> {
    return this.httpClient
      .get<Movie>(`${MOVIES_URL}/${id}`, HTTP_OPTIONS)
      .pipe(
        tap(movie => console.log(`Fetched movie with id [${movie.id}]`)),
        catchError(this.onError<Movie>("fetchMovie", new Movie()))
      );
  }

  updateMovie(movie: Movie): Observable<any> {
    return this.httpClient
    .put<Movie>(`${MOVIES_URL}/${movie.id}`, movie, HTTP_OPTIONS)
    .pipe(
      tap(_ => console.log(`Updated movie with id [${movie.id}]`)),
      catchError(this.onError<Movie>("updateMovie", new Movie()))
    );
  }

  deleteMovie(movie: Movie): Observable<any> {
    return this.httpClient
    .delete<Movie>(`${MOVIES_URL}/${movie.id}`, HTTP_OPTIONS)
    .pipe(
      tap(_ => console.log(`Deleted movie with id [${movie.id}]`)),
      catchError(this.onError<Movie>("deleteMovie", new Movie()))
    );
  }

  searchMovies(searchTerm: string): Observable<Movie[]> {
    return this.httpClient
      .get<Movie[]>(`${MOVIES_URL}?q=${searchTerm}`, HTTP_OPTIONS)
      .pipe(
        tap(movies => console.log(`Search found [${movies.length}] movies`)),
        catchError(this.onError<Movie[]>("searchMovies", []))
      );
  }

  private onError<T>(operation = "operation", result?: T) {
    return (error: any): Observable<T> => {
      console.error(`[${operation}] failed with error [${error.status} / ${error.message}]`);
      return of(result as T);
    };
  }
}

