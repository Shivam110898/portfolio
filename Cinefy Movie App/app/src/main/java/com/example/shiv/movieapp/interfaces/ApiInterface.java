package com.example.shiv.movieapp.interfaces;

import com.example.shiv.movieapp.response.CastResponse;
import com.example.shiv.movieapp.response.GenresResponse;
import com.example.shiv.movieapp.models.Movie;
import com.example.shiv.movieapp.response.MoviesResponse;
import com.example.shiv.movieapp.response.ReviewResponse;
import com.example.shiv.movieapp.response.TrailerResponse;
import retrofit2.Call;
import retrofit2.http.GET;
import retrofit2.http.Path;
import retrofit2.http.Query;

public interface ApiInterface {
    //all the API endpoints that are used to call the web service
    @GET("movie/top_rated")
    Call<MoviesResponse> getTopRatedMovies(@Query("api_key") String apiKey, @Query("page") int page
    );

    @GET("movie/popular")
    Call<MoviesResponse> getPopularMovies(@Query("api_key") String apiKey, @Query("page") int page
    );

    @GET("movie/upcoming")
    Call<MoviesResponse> getUpcomingMovies(@Query("api_key") String apiKey, @Query("page") int page
    );

    @GET("movie/now_playing")
    Call<MoviesResponse> getNowPlayingMovies(@Query("api_key") String apiKey, @Query("page") int page
    );

    @GET("genre/movie/list")
    Call<GenresResponse> getGenres(@Query("api_key") String apiKey);

    @GET("movie/{movie_id}/videos")
    Call<TrailerResponse> getTrailers(@Path("movie_id") int id, @Query("api_key") String apiKEy
    );

    @GET("movie/{movie_id}/reviews")
    Call<ReviewResponse> getReviews(@Path("movie_id") int id, @Query("api_key") String apiKEy
    );

    @GET("movie/{movie_id}")
    Call<Movie> getMovie(@Path("movie_id") int id, @Query("api_key") String apiKEy);

    @GET("movie/{movie_id}/credits")
    Call<CastResponse> getCast(@Path("movie_id") int id, @Query("api_key") String apiKEy);

}

