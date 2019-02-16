import { Component, OnInit } from "@angular/core";
import { MovieService } from "../movie.service";
import { Movie } from "../movie";

@Component({
  selector: "app-movies",
  templateUrl: "./movies.component.html",
  styleUrls: ["./movies.component.css"]
})
export class MoviesComponent implements OnInit {

  movies: Movie[];

  constructor(private movieService: MovieService) { }

  ngOnInit(): void {
    this.getMovies();
  }

  delete(movie: Movie): void {
    this.movieService.deleteMovie(movie).subscribe(_ => this.getMovies());
  }

  private getMovies(): void {
    this.movieService.fetchMovies().subscribe(movies => this.movies = movies);
  }
}
