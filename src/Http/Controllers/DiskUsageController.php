<?php

namespace Donald1597\DiskUsage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class DiskUsageController extends Controller
{
    public function index()
    {
        $projectPath = base_path();
        $diskUsage = $this->getDirectorySize($projectPath);

        $projectName = basename($projectPath);
        $formattedProjectName = strtoupper(str_replace(['_', '-'], ' ', $projectName));

        if ($diskUsage < (1024 ** 3)) {
            $totalSize = number_format($diskUsage / (1024 ** 2), 2) . ' MB';
        } else {
            $totalSize = number_format($diskUsage / (1024 ** 3), 2) . ' GB';
        }

        $totalDiskSpace = disk_total_space('/');
        $freeDiskSpace = disk_free_space('/');
        $usedDiskSpace = $totalDiskSpace - $freeDiskSpace;

        if ($totalDiskSpace < (1024 ** 3)) {
            $totalDiskSpaceFormatted = number_format($totalDiskSpace / (1024 ** 2), 2) . ' MB';
        } else {
            $totalDiskSpaceFormatted = number_format($totalDiskSpace / (1024 ** 3), 2) . ' GB';
        }

        if ($freeDiskSpace < (1024 ** 3)) {
            $freeDiskSpaceFormatted = number_format($freeDiskSpace / (1024 ** 2), 2) . ' MB';
        } else {
            $freeDiskSpaceFormatted = number_format($freeDiskSpace / (1024 ** 3), 2) . ' GB';
        }

        if ($usedDiskSpace < (1024 ** 3)) {
            $usedDiskSpaceFormatted = number_format($usedDiskSpace / (1024 ** 2), 2) . ' MB';
        } else {
            $usedDiskSpaceFormatted = number_format($usedDiskSpace / (1024 ** 3), 2) . ' GB';
        }

        $directoryDetails = $this->getDirectoryDetails($projectPath);


        return view('disk-usage::index', [
            'projectName' => $formattedProjectName,
            'totalSize' => $totalSize,
            'totalDiskSpace' => $totalDiskSpaceFormatted,
            'freeDiskSpace' => $freeDiskSpaceFormatted,
            'usedDiskSpace' => $usedDiskSpaceFormatted,
            'directoryDetails' => $directoryDetails,
            'freeDiskSpaceBytes' => $freeDiskSpace,
            'usedDiskSpaceBytes' => $usedDiskSpace,
            'usedProjectDiskSpaceBytes' => $diskUsage,
        ]);
    }

    private function getDirectorySize($directory)
    {
        $size = 0;
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $size += $file->getSize();
            }
        }

        return $size;
    }

    private function getDirectoryDetails($directory)
    {
        $details = [];
        $iterator = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);

        foreach ($iterator as $file) {
            $details[] = [
                'name' => $file->getFilename(),
                'size' => $file->isFile() ? $this->formatSize($file->getSize()) : '',
                'type' => $file->isFile() ? 'File' : 'Directory',
            ];
        }

        return $details;
    }

    private function formatSize($size)
    {
        if ($size < (1024 ** 2)) {
            return number_format($size / 1024, 2) . ' KB';
        } elseif ($size < (1024 ** 3)) {
            return number_format($size / (1024 ** 2), 2) . ' MB';
        } else {
            return number_format($size / (1024 ** 3), 2) . ' GB';
        }
    }

    public function deleteOldFiles(Request $request)
    {
        $filePath = base_path($request->input('file'));

        if (is_file($filePath)) {
            unlink($filePath);
        } elseif (is_dir($filePath)) {
            $this->deleteDirectory($filePath);
        }

        return redirect()->back()->with('status', 'File or directory deleted successfully!');
    }

    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir) || is_link($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . "/" . $item)) {
                chmod($dir . "/" . $item, 0777);
                if (!$this->deleteDirectory($dir . "/" . $item)) {
                    return false;
                }
            }
        }

        return rmdir($dir);
    }
}
