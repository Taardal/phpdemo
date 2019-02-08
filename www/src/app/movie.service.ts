import { Injectable } from "@angular/core";
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Observable, of } from "rxjs";
import { catchError, tap, map } from "rxjs/operators";
import { Movie } from "./movie";
import { environment } from "../environments/environment"

const httpHeaders = {
  headers: new HttpHeaders({
    "Content-Type": "application/json",
    "responseType": "text"
  })
};

@Injectable({
  providedIn: "root"
})
export class MovieService {
  constructor(private httpClient: HttpClient) {}
  
  fetchMovies(): Observable<Movie[]> {
    return this.httpClient.get<Movie[]>(environment.baseUrl, httpHeaders).pipe(
      tap(movies => console.log(`Fetched [${movies.length}] movies`)),
      catchError(this.onError<Movie[]>("fetchMovies", []))
    );
  }

  private onError<T>(operation = "operation", result?: T) {
    return (error: any): Observable<T> => {
      console.error(`[${operation}] failed with error [${error.status} / ${error.message}]`);
      return of(result as T);
    };
  }
}
