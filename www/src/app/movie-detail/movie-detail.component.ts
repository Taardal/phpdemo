import { Component, OnInit, Input } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Location } from '@angular/common';
import { MovieService } from '../movie.service';
import { Movie } from '../movie';

@Component({
  selector: 'app-movie-detail',
  templateUrl: './movie-detail.component.html',
  styleUrls: ['./movie-detail.component.css']
})
export class MovieDetailComponent implements OnInit {

  @Input() movie: Movie;

  constructor(
    private location: Location,
    private activatedRoute: ActivatedRoute,  
    private movieService: MovieService,
  ) { }

  ngOnInit(): void {
    this.getMovie();
  }

  goBack(): void {
    this.location.back();
  }

  save(): void {
    this.movieService.updateMovie(this.movie).subscribe(() => this.goBack());
  }

  private getMovie(): void {
    const id = this.activatedRoute.snapshot.paramMap.get('id');
    this.movieService.fetchMovie(+id).subscribe(movie => this.movie = movie);
  }

}
