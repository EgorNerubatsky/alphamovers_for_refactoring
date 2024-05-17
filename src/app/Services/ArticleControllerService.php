<?php

namespace App\Services;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\ArticleStoreRequest;
use App\Models\Article;
use App\Models\ArticleFavorite;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ArticleControllerService extends Controller
{
    protected RolesRoutingService $rolesRoutingService;

    private Article                $articleModel;
    private FilesActivityService $filesActivityModel;




    private ArticleFavorite $articleFavoriteModel;

    public function __construct(
        RolesRoutingService $rolesRoutingService,
        Article                $articleModel,
        ArticleFavorite $articleFavoriteModel,
        FilesActivityService $filesActivityModel,

    )
    {
        $this->rolesRoutingService = $rolesRoutingService;
        $this->articleModel = $articleModel;
        $this->articleFavoriteModel = $articleFavoriteModel;
        $this->filesActivityModel = $filesActivityModel;

    }

    public function showRandomArticle(): Application|Factory|View|\Illuminate\Contracts\Foundation\Application
    {

        $currentArticle = Article::inRandomOrder()->first();
        $allArticles = Article::query();

        $articles = $allArticles->paginate(10);
        return $this->articlesView($currentArticle,$articles, 'index');
    }

    public function showSelectedArticle($id): Application|Factory|View|\Illuminate\Contracts\Foundation\Application
    {
        $currentArticle = Article::findOrFail($id);
        $allArticles = Article::query();
        $articles = $allArticles->paginate(10);
        return $this->articlesView($currentArticle,$articles,'index');
        }

        public function articleSearch(SearchRequest $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
        {
            $search = $request->input('search');
            $articles = $this->articleModel->searchArticle($search);
            $currentArticle = $articles->first();

            return $this->articlesView($currentArticle,$articles, 'index');
        }

    public function articlesView($currentArticle, $articles, $view): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $favorites = ArticleFavorite::where('user_id', $user->id)->get();
        $roleData = $this->rolesRoutingService->getRoleData($user);

        return view('erp.parts.articles.'.$view, compact('articles', 'currentArticle', 'favorites', 'roleData'));
    }

    public function storeNewArticle(ArticleStoreRequest $request): void
    {
        $user = Auth::user();
        $path = $this->filesActivityModel->addFile($request, "article_file", "uploads/articles/");

        $this->articleModel->newArticle($request->input('title'), $request->input('content'), $user->id, $path);
    }

    public function storeUpdatedArticle(Request $request, $id): RedirectResponse
    {
        $updatedArticle = Article::findOrFail($id);
            $path = $this->filesActivityModel->addFile($request, "article_file", "uploads/articles/");
        $this->articleModel->updateArticle($updatedArticle, $request->input('title'), $request->input('content'), $path);

        return $this->articleIndexRedirect();
    }

    public function toFavorites(int $id): RedirectResponse
    {
        $favoriteArticle = Article::findOrFail($id);
        $user = Auth::user();

        if ($favoriteArticle->articleFavorites()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Статья уже в избранном');
        }

        $this->articleFavoriteModel->newArticleFavorite($id, $user->id);
        return redirect()->back()->with('reload', true);

         }

    public function deleteArticle($id): RedirectResponse
    {
        $deletedArticle = Article::findOrFail($id);
        $deletedArticle->delete();
        $this->articleModel->deleteArticle($id);
        $this->articleFavoriteModel->deleteArticleFavorite($id);

        return $this->articleIndexRedirect();
    }

    public function articleIndexRedirect(): RedirectResponse
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);

        return redirect()->route($roleData['roleData']['articles_index']);
    }

    public function deleteArticleFile($id): RedirectResponse
    {
        $this->articleModel->deleteFile($id);

        return $this->articleIndexRedirect();
    }


}


