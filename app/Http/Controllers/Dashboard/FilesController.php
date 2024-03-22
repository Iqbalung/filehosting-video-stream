<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\StorageServerHelper;
use App\Http\Controllers\Controller;
use App\Models\Directory;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FilesController extends Controller
{
    /**
     * @var FileService
     */
    protected $fileService;

    /**
     * FilesController constructor.
     * @param FileService $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $directories = Directory::query();
        $files = File::query();
        $parrentDirectory = 0;
        $directoryName = '...';

        if ($request->has('folder_id') && $request->query('folder_id') != null) {
            $directory = Directory::select('directory_parrent_id', 'name')
                ->where('user_id', Auth::id())
                ->where('id', $request->query('folder_id'))
                ->first();

            $directoryName = $directory->name;
            $parrentDirectory = $directory
                ->directory_parrent_id;

            $folder_id = explode(',', $request->query('folder_id'));
            $files = $files->whereIn('directory_id', $folder_id);
        } else {
            $directories = $directories->where('directory_parrent_id', null);
        }

        $files = $files
            ->where('user_id', Auth::id())
            ->where('client_original_name', 'like', '%'. $request->query('search') .'%')
            ->orderBy('id', 'desc');

          
            $files = $files->paginate(10);

        $directories = $directories
            ->where('user_id', Auth::id())
            ->get();

        return view('dashboard.files.index', compact(
            'directories', 'files', 'parrentDirectory', 'directoryName'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $directories = Directory::with('childrenDirectory')
            ->where('directory_parrent_id', null)
            ->get();

        return view('dashboard.files.create', compact('directories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'video' => 'required',
            'directory_id' => 'nullable'
        ]);

        $directoryID = Directory::where('user_id', Auth::id())->find($request->directory_id)->id ?? null;

        $fileDatabase = $this->fileService->store($request, $directoryID);

        return redirect()
            ->route('dashboard.files.index')
            ->with('success', 'Berhasil di upload')
            ->with('file', $fileDatabase);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $id = explode(',', $id);
        File::whereIn('id',$id)->delete();
        return redirect()
            ->route('dashboard.files.index')
            ->with('success', 'Berhasil Hapus');
    }

    public function search(Request $request)
    {
        $search = $request->get('query');
        if(!empty($request->get('folder_id') != null))
        {
            $folder_id = explode(',', $request->get('folder_id'));
            $files = $files = File::where('client_original_name', 'like', '%' . $search . '%')->whereIn('directory_id', $folder_id)->get();
        }else{
            $files = File::where('client_original_name', 'like', '%' . $search . '%')->OrWhere('code', 'like', '%' . $search . '%')->get();
        }
        $output = '<datalist id="list-timezone" >';
        foreach($files as $file)
        {
            $output .= ' <option style="width:700px;">'.$file->client_original_name.'</option>';
        }
        $output .= '</datalist>';

        return $output;
    }
}


