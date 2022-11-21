import React, {FC} from 'react';
import {Paper, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Typography} from "@mui/material";
import {IMostDonatedOrganizations} from "../../../models/IMostDonatedOrganizations";

interface TableProps {
    mostDonatedOrganizations: IMostDonatedOrganizations[]
}

const MostDonatedOrganizationsTable: FC<TableProps> = ({mostDonatedOrganizations}) => {

    if (mostDonatedOrganizations.length === 0) {
        return <Typography variant="h6" sx={{mb: 3}}>You have not donated to any company more than 100 bucks in a year.</Typography>
    }

    return (
        <>
            <Typography variant="h5" sx={{mb: 3}}>Most important companies</Typography>
            <TableContainer component={Paper} sx={{mb: 3}}>
                <Table size="small" aria-label="a dense table">
                    <TableHead>
                        <TableRow>
                            <TableCell><b>Company</b></TableCell>
                            <TableCell align="right"><b>Total sent ($)</b></TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {mostDonatedOrganizations.map((row) => (
                            <TableRow>
                                <TableCell>{row.name}</TableCell>
                                <TableCell align="right">{row.total_sent}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </TableContainer>
        </>
    );
};

export default MostDonatedOrganizationsTable;