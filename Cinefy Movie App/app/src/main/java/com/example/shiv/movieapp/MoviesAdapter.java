package com.example.shiv.movieapp;

import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.example.shiv.movieapp.interfaces.OnMoviesClickCallback;
import com.example.shiv.movieapp.models.Genre;
import com.example.shiv.movieapp.models.Movie;
import java.util.ArrayList;
import java.util.List;

public class MoviesAdapter extends RecyclerView.Adapter<MoviesAdapter.MovieViewHolder>{

    private List<Movie> movies;
    private List<Genre> allGenres;
    private OnMoviesClickCallback callback;

    class MovieViewHolder extends RecyclerView.ViewHolder {

        Movie movie;
        TextView movieTitle;
        TextView releaseDate;
        TextView rating;
        TextView genres;
        ImageView poster;

        MovieViewHolder(View itemView) {
            super(itemView);
            //movieTitle = itemView.findViewById(R.id.title);
            //releaseDate = itemView.findViewById(R.id.releaseDate);
            //genres = itemView.findViewById(R.id.genre);
            //rating = itemView.findViewById(R.id.rating);
            poster = itemView.findViewById(R.id.poster);

            itemView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    callback.onClick(movie);
                }
            });

        }

        void bind(Movie movie)
        {
            this.movie = movie;
            //movieTitle.setText(movie.getTitle());
            //releaseDate.setText(movie.getReleaseDate());
            //rating.setText(String.valueOf(movie.getRating()));
            //genres.setText(getGenres(movie.getGenreIds()));
            String IMAGE_BASE_URL = "http://image.tmdb.org/t/p/w500";
            Glide.with(itemView)
                    .load(IMAGE_BASE_URL + movie.getPosterPath())
                    .apply(RequestOptions.placeholderOf(R.color.colorPrimary))
                    .into(poster);

        }

        private String getGenres(List<Integer> genreIds) {
            List<String> movieGenres = new ArrayList<>();
            for (Integer genreId : genreIds) {
                for (Genre genre : allGenres) {
                    if (genre.getId() == genreId) {
                        movieGenres.add(genre.getName());
                        break;
                    }
                }
            }
            return TextUtils.join(", ", movieGenres);
        }
    }

    public MoviesAdapter(List<Movie> movies, List<Genre> allGenres, OnMoviesClickCallback callback) {
        this.callback = callback;
        this.movies  = movies;
        this.allGenres = allGenres;

    }

    @Override
    public MoviesAdapter.MovieViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.movie_item, parent, false);


        return new MovieViewHolder(view);
    }

    @Override
    public void onBindViewHolder(MovieViewHolder holder, final int position) {
        holder.bind(movies.get(position));

    }

    @Override
    public int getItemCount() {
        return movies.size();
    }

    public void appendMovies(List<Movie> moviesToAppend) {
        movies.addAll(moviesToAppend);
        notifyDataSetChanged();
    }

    public void clearMovies() {
        movies.clear();
        notifyDataSetChanged();
    }

}
