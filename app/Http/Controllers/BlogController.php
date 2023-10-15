<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\Create;
use App\Http\Requests\Blog\Update;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Tag;
use App\Models\Link;
use Yajra\DataTables\DataTables;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        $user = User::find(session('LoggedUser'));


        if ($user->id === 1) {
            $blogs = Blog::with('tags', 'user', 'file')->get();
        } else {
            $blogs = $user->blogs()->with('user', 'file')->get();

        }
        if ($request->ajax()) {

            return Datatables::of($blogs)
                ->addColumn('action', function ($blog) {
                    // Generate the edit and delete buttons (if needed)
                    return '<a href="' . route('blogs.edit', $blog->id) . '" class="btn btn-primary">Edit</a> ';
                })
                ->make(true);
        }

        return view('blog.blog-list');
    }

    public function show(Blog $blog)
    {
        return view('blog.blog-create', compact('blog'));
    }

    public function showBlogTags($id)
    {
        $blog = Blog::findOrFail($id);
        $tags = $blog->tags;

        return view('blog.show-tag', compact('blog', 'tags'));
    }

    public function showBlogLink($id)
    {
        $blog = Blog::findOrFail($id);
        $links = $blog->links;

        return view('blog.show-link', compact('blog', 'links'));
    }

    public function edit(Blog $blog)
    {
        return view('blog.blog-update', compact('blog'));
    }

    public function update(Update $request, $id)
    {
        $user = User::find(session('LoggedUser'));
        $blog = Blog::findOrFail($id);

        // Fetch the currently logged-in user

        // Update basic attributes
        $blog->user_id = $user->id;
        $blog->title = $request->title;
        $blog->description = $request->description;

        // Update or replace tags
        if ($request->input('tags')) {
            $tagNames = explode(',', $request->input('tags'));
            $tags = collect($tagNames)->map(function ($tagName) {
                return Tag::firstOrCreate(['name' => $tagName]);
            });
            $blog->tags()->sync($tags->pluck('id'));
        } else {
            $blog->tags()->detach(); // Remove any existing tags if none are provided
        }

        // Update or replace links
        $newLinksData = $request->links ?? [];
        $newLinks = [];

        foreach ($newLinksData as $linkData) {
            $newLinks[] = new Link([
                'title' => $linkData['title'],
                'url' => $linkData['url'],
            ]);
        }

        $blog->links()->delete(); // Remove all existing links
        $blog->links()->saveMany($newLinks);

        // Handle image uploads
        if ($request->hasFile('blog_images')) {
            foreach ($request->file('blog_images') as $image) {
                $this->processAndAttachImage($image, $blog);
            }
        }

        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully');
    }

    public function store(Create $request)
    {
        // Validate the incoming form data

        // Create a new blog instance
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->description = $request->description;

        // Associate the authenticated user with the blog
        $user = User::find(session('LoggedUser'));
        $blog->user_id = $user->id;

        // Save the blog
        $blog->save();

        // Process and attach tags
        if ($request->input('tags')) {
            $tagNames = explode(',', $request->input('tags'));
            $tags = collect($tagNames)->map(function ($tagName) {
                return Tag::firstOrCreate(['name' => $tagName]);
            });
            $blog->tags()->sync($tags->pluck('id'));
        }

        if ($request->input('links')) {
            $links = $request->input('links');
            foreach ($links as $link) {
                Link::create([
                    'blog_id' => $blog->id,
                    'title' => $link['title'],
                    'url' => $link['url'],
                ]);
            }
        }

        // Handle image uploads
        if ($request->hasFile('blog_images')) {
            $images = $request->file('blog_images');

            foreach ($images as $image) {
                $this->processAndAttachImage($image, $blog);
            }
        }

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

// Helper method to process and attach an image to the blog
    private function processAndAttachImage($image, $blog)
    {
        // Determine the storage path
        $imagePath = 'blog_images';
        $imageName = $image->getClientOriginalName();
        $image->storeAs($imagePath, $imageName);

        // Create a new File record
        $file = new File();
        $file->name = $imageName;
        $file->local_path = $imagePath . '/' . $imageName;
        $file->type = File::TYPE_BLOG_IMAGE;
        $file->save();

        // Associate the file with the blog
        $blog->file_id = $file->id;
        $blog->save();
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['error' => 'Blog not found'], 404);
        }

        // Delete any associated tags and links
        $blog->tags()->detach();
        $blog->links()->delete();

        // Delete any associated images (optional, based on your implementation)
        if ($blog->file) {
            $blog->file->delete();
        }

        // Finally, delete the blog
        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully'], 200);
    }

    public function viewBlogs($id)
    {
        $blog = Blog::with('user', 'tags', 'links')->find($id);

        return view('blog.show', compact('blog'));
    }


}
