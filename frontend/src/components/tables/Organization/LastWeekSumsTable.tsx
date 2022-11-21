import React, {FC, ReactElement} from 'react';
import {
    TableContainer,
    Table,
    TableHead,
    Paper,
    TableRow,
    TableCell,
    TableBody, Typography
} from "@mui/material";
import {ILastWeekSum} from "../../../models/ILastWeekSum";

interface TableProps {
    lastWeekSum: ILastWeekSum[]
}

const LastWeekSumsTable: FC<TableProps> = ({lastWeekSum}): ReactElement => {

    return (
        <>
            <Typography variant="h5" sx={{mb: 3}}>Last week contributors sums</Typography>
            <TableContainer component={Paper} sx={{mb: 3}}>
                <Table size="small" aria-label="a dense table">
                    <TableHead>
                        <TableRow>
                            <TableCell><b>Firstname</b></TableCell>
                            <TableCell><b>Lastname</b></TableCell>
                            <TableCell><b>Total ($)</b></TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {lastWeekSum.map((row) => (
                            <TableRow>
                                <TableCell>{row.first_name}</TableCell>
                                <TableCell>{row.last_name}</TableCell>
                                <TableCell>{row.total_sent}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </TableContainer>
        </>
    );
};

export default LastWeekSumsTable;