<?php

namespace App\Service;

class SudokuPlusValidator
{
    /**
     * @param string $csvText
     * @return bool
     */
    public function validateSudoku(string $csvText): bool
    {
        $grid = $this->convertCsvToGrid($csvText);

        if (!$this->validateGridSize($grid)) {
            return false;
        }

        if (!$this->validateGridContent($grid)) {
            return false;
        }

        if (!$this->validateRegions($grid)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $csvText
     * @return array
     */
    private function convertCsvToGrid(string $csvText): array
    {
        $rows = explode("\n", $csvText);

        // Remove empty rows at the end of the grid
        while (!empty($rows) && empty(end($rows))) {
            array_pop($rows);
        }

        $grid = [];
        foreach ($rows as $row) {
            $columns = array_map('trim', explode(",", $row));
            $grid[] = $columns;
        }

        return $grid;
    }

    /**
     * @param array $grid
     * @return bool
     */
    private function validateGridSize(array $grid): bool
    {
        $rowCount = count($grid);
        $columnCount = count($grid[0]);

        // Check if the number of columns is the same for all rows
        foreach ($grid as $row) {
            if (count($row) !== $columnCount) {
                return false;
            }
        }

        // Check if the grid is square
        if ($rowCount !== $columnCount) {
            return false;
        }

        return true;
    }

    /**
     * @param array $grid
     * @return bool
     */
    private function validateGridContent(array $grid): bool
    {
        $sideLength = count($grid);

        foreach ($grid as $row) {
            foreach ($row as $value) {
                if (!is_numeric($value) || $value < 1 || $value > $sideLength) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param array $grid
     * @return bool
     */
    private function validateRegions(array $grid): bool
    {
        $sideLength = count($grid);
        $regionSize = sqrt($sideLength);

        for ($startRow = 0; $startRow < $sideLength; $startRow += $regionSize) {
            for ($startCol = 0; $startCol < $sideLength; $startCol += $regionSize) {
                $region = [];
                for ($row = $startRow; $row < $startRow + $regionSize; $row++) {
                    for ($col = $startCol; $col < $startCol + $regionSize; $col++) {
                        $value = $grid[$row][$col];
                        if ($value === 0 || isset($region[$value])) {
                            return false;
                        }
                        $region[$value] = true;
                    }
                }
            }
        }
        return true;
    }
}