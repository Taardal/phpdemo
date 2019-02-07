import { Injectable } from "@angular/core";
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Observable, of } from "rxjs";
import { catchError, tap, map } from "rxjs/operators";
import { Movie } from "./movie";

const httpHeaders = {
  headers: new HttpHeaders({
    "Content-Type": "application/json"
  })
};

@Injectable({
  providedIn: "root"
})
export class MovieService {
  constructor(private httpClient: HttpClient) {}

  fetchMovies(): Observable<Movie[]> {
    const url = "http://localhost:4201";
    return this.httpClient.get<Movie[]>(url, httpHeaders).pipe(
      tap(_ => console.log("Fetching movies...")),
      catchError(this.onError("fetchHeroes", []))
    );
  }

  private onError<T>(operation = "operation", result?: T) {
    return (error: any): Observable<T> => {
      console.error(
        `[${operation}] failed with error [${error.status} / ${error.message}]`
      );
      return of(result as T);
    };
  }
}
