<?php

namespace App\Services;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\ApplicantFormRequest;
use App\Models\Applicant;
use App\Models\CandidatesFile;
use App\Models\Interviewee;
use App\Models\User;
use App\Models\UsersFile;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;


class FilesActivityService extends Controller
{
    protected RolesRoutingService $rolesRoutingService;
    private Applicant $applicantModel;
    private User $userModel;
    private CandidatesFile $candidateFileModel;

    private Interviewee $intervieweeModel;

    private         UsersFile $usersFileModel;


    use HasFactory, SoftDeletes;

    public function __construct(
        RolesRoutingService $rolesRoutingService,
        Applicant           $applicantModel,
        User                $userModel,
        CandidatesFile      $candidateFileModel,
        Interviewee $intervieweeModel,
        UsersFile $usersFileModel,
    )
    {

        $this->rolesRoutingService = $rolesRoutingService;
        $this->applicantModel = $applicantModel;
        $this->userModel = $userModel;
        $this->candidateFileModel = $candidateFileModel;
        $this->intervieweeModel = $intervieweeModel;
        $this->usersFileModel = $usersFileModel;
    }

    public function addFile($request, $fileType, $diskPath): ?string
    {
        $path = null;
        if ($request->hasFile($fileType) && $request->file($fileType)->isValid()) {
            $file = $request->file($fileType);
            $fileName = $file->getClientOriginalName();
            $path = $diskPath . $fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
        }
        return $path;
    }

    public function multipleAddFiles($request, $requestField, $pathPart): array
    {
        $attachments = $request->file($requestField);
        $attachmentPaths = [];

            foreach ($attachments as $attachment) {
                $attachmentDocumentName = $attachment->getClientOriginalName();
                $path = $pathPart . $attachmentDocumentName;
                Storage::disk('public')->put($path, file_get_contents($attachment));
                $attachmentPaths[] = $path;
            }

        return $attachmentPaths;
    }

    public function multipleStoreFiles($message, $pathPart): bool|string
    {
        $attachmentPaths = [];
        foreach ($message->getAttachments() as $attachment) {

            $filename = $attachment->getFilename();

            if (mb_strlen($filename) > 30) {
                $filename = uniqid() . '.' . $attachment->getExtension();
            } else {
                $filename = $attachment->getFilename();
            }
            $attachmentContent = $attachment->getContent();
            if (!file_exists($pathPart)) {
                mkdir($pathPart, 0755, true);
            }
            $attachmentPath = "$pathPart/$filename";
            file_put_contents(public_path($attachmentPath), $attachmentContent);


            $attachmentPaths[] = $attachmentPath;
        }

        return json_encode($attachmentPaths);
    }

    public function filesTransfer($newUser, $file, $candidateType): ?string
    {
        $path = $file->path;
        $fileType = 'files';
        if($file->description == 'photos'){
            $fileType = 'photos';
        }
        $newPath = "uploads/$fileType/$candidateType/$newUser->id/";
        $newFilePath = $this->removeFile($path, $newPath);

        $this->deleteFile($path);
        $file->delete();

        return $newFilePath;
    }

    public function removeFile($path, $newPath): ?string
    {
        $file = Storage::disk('public')->get($path);
        $newFilePath = null;
        if($file !== false){
            $newFileName = pathinfo($path, PATHINFO_BASENAME);
            $newFilePath = $newPath.$newFileName;
            Storage::disk('public')->put($newFilePath, $file);
            Storage::disk('public')->delete($path);
        }
        return $newFilePath;
    }

    public function deleteFile($path): void
    {
        $filePath = public_path($path);
//        if(is_file($filePath)){
//            unlink($filePath);
            Storage::disk('public')->delete($path);

//        }

        $directory = dirname($filePath);
        if (is_dir($directory) && count(scandir($directory)) == 2){
            rmdir($directory);
        }
    }

}


