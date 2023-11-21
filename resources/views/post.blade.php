@extends('master')

@section('content')
<div class="container" x-data="{ post: {}, authKey: '', errorMessage: '' }" x-init="post = await (await fetch('/api/blog/{{request()->segment(count(request()->segments()))
}}')).json()">
    <div class="box">
        <article class="media">
            <div class="media-left">
                <figure class="image is-64x64">
                    <img :src="'https://ui-avatars.com/api/?name=' + post.author" alt="Image">
                </figure>
            </div>
            <div class="media-content">
                <div class="content">
                    <p>
                        <strong x-text="post.title"></strong> @<small x-text="post.author"></small>
                        <br>
                        <span x-html="post.content"></span>
                    </p>
                </div>
            </div>
        </article>
    </div>
    <h1 class="title">Autorizační heslo</h1>
    <div class="field">
    <input class="input" placeholder="authKey" x-model="authKey">
    </div>
    <div class="notification is-danger" x-show="errorMessage.length > 0" x-text="errorMessage"></div>
    <h1 class="title">Aktualizace článku</h1>
    <div x-data="{
        actionUpdate() { fetch(`/api/blog/${post.id}`, {
            method: 'PATCH',
            headers: {
                'Authorization': authKey,
                'content-type': 'application/json'
            },
            body: JSON.stringify({title: post.title, content: post.content})
        }).then(response => {
            if (!response.ok) {
                throw new Error(`Error ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            window.location.href = '/';
        })
        .catch(error => {
            errorMessage = error.message || 'An error occurred.';
        }); }
    }">
        <div class="field">
            <label class="label">Název článku</label>
            <div class="control">
                <input class="input" type="text" placeholder="Název článku" name="title" x-model="post.title">
            </div>
        </div>
        <div class="field">
            <label class="label">Obsah</label>
            <div class="control">
                <textarea class="textarea" placeholder="Lorem ipsum.." name="content" x-model="post.content"></textarea>
            </div>
        </div>
        <button class="button is-primary" x-on:click="actionUpdate">Odeslat</button>
    </form>
    <h1 class="title">Odstranit článek</h1>
    <div x-data="{
        actionDelete() { fetch(`/api/blog/${post.id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': authKey,
            }
        }).then(response => {
            if (!response.ok) {
                throw new Error(`Error ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            window.location.href = '/';
        })
        .catch(error => {
            errorMessage = error.message || 'An error occurred.';
        }); }
    }">
        <button class="button is-danger" x-on:click="actionDelete">Odstranit</button>
    </div>
</div>
@endsection
