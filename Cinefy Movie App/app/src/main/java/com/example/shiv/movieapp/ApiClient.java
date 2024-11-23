package com.example.shiv.movieapp;

import com.example.shiv.movieapp.interfaces.ApiInterface;
import com.example.shiv.movieapp.interfaces.OnGetCastCallback;
import com.example.shiv.movieapp.interfaces.OnGetGenresCallback;
import com.example.shiv.movieapp.interfaces.OnGetMovieCallback;
import com.example.shiv.movieapp.interfaces.OnGetMoviesCallback;
import com.example.shiv.movieapp.interfaces.OnGetReviewsCallback;
import com.example.shiv.movieapp.interfaces.OnGetTrailersCallback;
import com.example.shiv.movieapp.models.Movie;
import com.example.shiv.movieapp.response.CastResponse;
import com.example.shiv.movieapp.response.GenresResponse;
import com.example.shiv.movieapp.response.MoviesResponse;
import com.example.shiv.movieapp.response.ReviewResponse;
import com.example.shiv.movieapp.response.TrailerResponse;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class ApiClient {

    private static final String BASE_URL = "https://api.themoviedb.org/3/";
    private static final String API_KEY = "634d6df906f4407c4fd09a243860bc3a";
    public static final String POPULAR = "popular";
    public static final String TOP_RATED = "top_rated";
    public static final String UPCOMING = "upcoming";
    public static final String NOW_PLAYING = "now_playing";
    private static ApiClient apiClient;
    private ApiInterface api;

    private ApiClient(ApiInterface api)
    {
        this.api = api;
    }

    public static ApiClient getInstance() {
        if (apiClient ==null) {
            Retrofit retrofit = new Retrofit.Builder()
                    .baseUrl(BASE_URL)
                    .addConverterFactory(GsonConverterFactory.create())
                    .build();

            apiClient = new ApiClient(retrofit.create(ApiInterface.class));
        }
       return apiClient;
    }


    public void getMovies(int page, String sortBy, final OnGetMoviesCallback callback) {
        Callback<MoviesResponse> call = new Callback<MoviesResponse>() {
            @Override
            public void onResponse(Call<MoviesResponse> call, Response<MoviesResponse> response) {
                if (response.isSuccessful()) {
                    MoviesResponse moviesResponse = response.body();
                    if (moviesResponse != null && moviesResponse.getMovies() != null) {
                        callback.onSuccess(moviesResponse.getPage(), moviesResponse.getMovies());
                    } else {
                        callback.onError();
                    }
                } else {
                    callback.onError();
                }
            }

            @Override
            public void onFailure(Call<MoviesResponse> call, Throwable t) {
                callback.onError();
            }
        };

        switch (sortBy) {
            case TOP_RATED:
                api.getTopRatedMovies(API_KEY, page)
                        .enqueue(call);
                break;
            case UPCOMING:
                api.getUpcomingMovies(API_KEY, page)
                        .enqueue(call);
                break;
            case NOW_PLAYING:
                api.getNowPlayingMovies(API_KEY, page)
                        .enqueue(call);
                break;
            case POPULAR:
            default:
                api.getPopularMovies(API_KEY, page)
                        .enqueue(call);
                break;
        }
    }

    public void getMovie(int movieId, final OnGetMovieCallback callback) {
        api.getMovie(movieId, API_KEY)
                .enqueue(new Callback<Movie>() {
                    @Override
                    public void onResponse(Call<Movie> call, Response<Movie> response) {
                        if (response.isSuccessful()) {
                            Movie movie = response.body();
                            if (movie != null) {
                                callback.onSuccess(movie);
                            } else {
                                callback.onError();
                            }
                        } else {
                            callback.onError();
                        }
                    }

                    @Override
                    public void onFailure(Call<Movie> call, Throwable t) {
                        callback.onError();
                    }
                });
    }

    public void getGenres(final OnGetGenresCallback callback) {
        api.getGenres(API_KEY)
                .enqueue(new Callback<GenresResponse>() {
                    @Override
                    public void onResponse(Call<GenresResponse> call, Response<GenresResponse> response) {
                        if (response.isSuccessful()) {
                            GenresResponse genresResponse = response.body();
                            if (genresResponse != null && genresResponse.getGenres() != null) {
                                callback.onSuccess(genresResponse.getGenres());
                            } else {
                                callback.onError();
                            }
                        } else {
                            callback.onError();
                        }
                    }

                    @Override
                    public void onFailure(Call<GenresResponse> call, Throwable t) {
                        callback.onError();
                    }
                });

    }

    public void getTrailers(int movieId, final OnGetTrailersCallback callback) {
        api.getTrailers(movieId, API_KEY)
                .enqueue(new Callback<TrailerResponse>() {
                    @Override
                    public void onResponse(Call<TrailerResponse> call, Response<TrailerResponse> response) {
                        if (response.isSuccessful()) {
                            TrailerResponse trailerResponse = response.body();
                            if (trailerResponse != null && trailerResponse.getTrailers() != null) {
                                callback.onSuccess(trailerResponse.getTrailers());
                            } else {
                                callback.onError();
                            }
                        } else {
                            callback.onError();
                        }
                    }

                    @Override
                    public void onFailure(Call<TrailerResponse> call, Throwable t) {
                        callback.onError();
                    }
                });
    }

    public void getReviews(int movieId, final OnGetReviewsCallback callback) {
        api.getReviews(movieId, API_KEY)
                .enqueue(new Callback<ReviewResponse>() {
                    @Override
                    public void onResponse(Call<ReviewResponse> call, Response<ReviewResponse> response) {
                        if (response.isSuccessful()) {
                            ReviewResponse reviewResponse = response.body();
                            if (reviewResponse != null && reviewResponse.getReviews() != null) {
                                callback.onSuccess(reviewResponse.getReviews());
                            } else {
                                callback.onError();
                            }
                        } else {
                            callback.onError();
                        }
                    }

                    @Override
                    public void onFailure(Call<ReviewResponse> call, Throwable t) {
                        callback.onError();
                    }
                });
    }
    public void getCast(int movieId, final OnGetCastCallback callback) {
        api.getCast(movieId, API_KEY)
                .enqueue(new Callback<CastResponse>() {
                    @Override
                    public void onResponse(Call<CastResponse> call, Response<CastResponse> response) {
                        if (response.isSuccessful()) {
                            CastResponse castResponse = response.body();
                            if (castResponse != null && castResponse.getCastList() != null) {
                                callback.onSuccess(castResponse.getCastList());
                            } else {
                                callback.onError();
                            }
                        } else {
                            callback.onError();
                        }
                    }

                    @Override
                    public void onFailure(Call<CastResponse> call, Throwable t) {
                        callback.onError();
                    }
                });
    }

}
