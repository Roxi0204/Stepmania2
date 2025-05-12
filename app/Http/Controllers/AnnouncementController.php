<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;



class AnnouncementController extends Controller
{
    public function index()
    {
        $paginate = Announcement::with ('user','category')->first();
        if(!$paginate){
            $paginate= Announcement::with ('user','category')->paginate(5);
        }else{
            $pagination= Announcement::with ('user','category')->orderBy('created_at','desc')->paginate($paginate->pagination);
        }
        $category= Category::get();
        $announcements = Announcement::with('category')->get();

         return Inertia::render('Announcements', [
            'pagination' => $pagination,
            'announcements' => $announcements,
            'categories' => $category,
            
        ]);
    }
   public function getByCategory(Request $request)
    {
      
        $categoryId = $request->params['category_id'];
        $page = $request->params['page'] ?? 1;
        $perPage = $request->params['per_page'] ?? 5;
        
        $query = Announcement::with('user', 'category')
            ->orderBy('created_at', 'desc');
        
        if ($categoryId !== 'all') {
            $query->where('category_id', $categoryId);
        }
        
        $announcements = $query->paginate($perPage, ['*'], 'page', $page);

        return $announcements;
}






    public function create(){

        $categories = Category::all();
        return Inertia::render('AnnouncementFormulari', [
            'categories' => $categories,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'email' => 'required|email',
            'category' => 'required|exists:categories,id',
        ]);

        Announcement::create([
            'title' => $request->title,
            'description' => $request->description,
            'email' => $request->email,
            'category_id' => $request->category,
            'user_id' => Auth::id(), // Assuming you have user authentication
        ]);

         // Redirect to the announcements index page with a success message

        return redirect()->route('announcements.index')->with('success', 'Announcement created successfully.');
    }
   public function show($id)
    {
       
        $announcement = Announcement::where('id',$id)->with ('category')->first();
        
        return Inertia::render('AnnouncementShow', [
            'announcement' => $announcement,
        ]);
    }
    public function edit($id)
    {
       
        $announcement = Announcement::where('id',$id)->with ('category')->first();
        $categories = Category::all();
        return Inertia::render('AnnouncementEdit', [
            'announcement' => $announcement,
            'categories' => $categories,
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'email' => 'required|email',
            'category' => 'required|exists:categories,id',
        ]);

        $announcement = Announcement::findOrFail($id);
        $announcement->update([
            'title' => $request->title,
            'description' => $request->description,
            'email' => $request->email,
            'category_id' => $request->category,
        ]);

         // Redirect to the announcements index page with a success message

        return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully.');
    }
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

         // Redirect to the announcements index page with a success message

        return $announcement;
    }
}
