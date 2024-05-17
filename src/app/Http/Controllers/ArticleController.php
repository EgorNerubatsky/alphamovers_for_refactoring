<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\ArticleStoreRequest;
use App\Models\Article;
use App\Services\ArticleControllerService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private ArticleControllerService $articleControllerService;


    public function __construct(
        ArticleControllerService $articleControllerService,
    )
    {
        $this->articleControllerService = $articleControllerService;
    }

    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return $this->articleControllerService->showRandomArticle();
    }

    public function search(SearchRequest $request): View|Factory|\Illuminate\Foundation\Application|Application
    {

        return $this->articleControllerService->articleSearch($request);
    }
    public function storeArticle(ArticleStoreRequest $request): RedirectResponse
    {
        $this->articleControllerService->storeNewArticle($request);
        return redirect()->back()->with('reload', true);

    }


    public function showArticle($id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return $this->articleControllerService->showSelectedArticle($id);
    }


    public function edit($id): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $currentArticle = Article::findOrFail($id);
        $allArticles = Article::query();

        $articles = $allArticles->paginate(10);

        return $this->articleControllerService->articlesView($currentArticle,$articles,'article_edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateArticle(Request $request, $id): RedirectResponse
    {
        return $this->articleControllerService->storeUpdatedArticle($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function addToFavorites($id): RedirectResponse
    {
        return $this->articleControllerService->toFavorites($id);
    }

    public function delete($id): RedirectResponse
    {
        return $this->articleControllerService->deleteArticle($id);
    }

    public function deleteFile($id): RedirectResponse
    {
        return $this->articleControllerService->deleteArticleFile($id);
    }


}
