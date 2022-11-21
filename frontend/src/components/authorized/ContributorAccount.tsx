import React, {FC, ReactElement, useContext, useEffect} from 'react';
import {
    Box,
    Container,
    Typography,
} from "@mui/material";
import {observer} from "mobx-react-lite";
import {Context} from "../../index";
import LastMonthDonatesTable from "../tables/Contributor/LastMonthDonatesTable";
import MostDonatedOrganizationsTable from "../tables/Contributor/MostDonatedOrganizationsTable";

const ContributorAccount: FC = (): ReactElement => {

    const {statisticsContributor} = useContext(Context)
    const {auth} = useContext(Context)

    useEffect(() => {
        statisticsContributor.getLastMonthDonates()
        statisticsContributor.getMostDonatedOrganizations()
        statisticsContributor.getAveragePerMonth()
    }, [])

    console.log(statisticsContributor.averagePerMonth)

    return (
        statisticsContributor.lastMonthDonates &&
        statisticsContributor.mostDonatedOrganizations &&

        <Box sx={{
            flexGrow: 1,
            backgroundColor: 'whitesmoke',
            display: 'flex',
            justifyContent: 'center'
        }}>
            <Container sx={{mt: 3, mb: 3}} maxWidth="md">
                <Typography variant="h3" sx={{mb: 3}}>{auth.user.account_title}</Typography>
                <Typography variant="h5" sx={{mb: 3}}>Average per month: <b>{statisticsContributor.averagePerMonth} $</b></Typography>
                <LastMonthDonatesTable lastMonthDonates={statisticsContributor.lastMonthDonates} />
                <MostDonatedOrganizationsTable mostDonatedOrganizations={statisticsContributor.mostDonatedOrganizations} />
            </Container>
        </Box>
    );
};

export default observer(ContributorAccount);