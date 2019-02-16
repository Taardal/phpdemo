import { Component, OnInit } from "@angular/core";
import { Movie } from "../movie";
import { MovieService } from "../movie.service";

@Component({
  selector: "app-dashboard",
  templateUrl: "./dashboard.component.html",
  styleUrls: ["./dashboard.component.css"]
})
export class DashboardComponent implements OnInit {
  
  movies: Movie[];

  constructor(private movieService: MovieService) {}

  ngOnInit(): void {
    this.getMovies();
  }

  private getMovies(): void {
    this.movieService.fetchMovies().subscribe(movies => this.movies = movies);
  }

}
