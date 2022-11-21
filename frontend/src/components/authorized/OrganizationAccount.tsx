import React, {FC, ReactElement, useContext, useEffect} from 'react';
import {
    Box,
    Container,
    Typography,
    Tabs,
    Tab
} from "@mui/material";
import {observer} from "mobx-react-lite";
import {Context} from "../../index";
import LastWeekSumsTable from "../tables/Organization/LastWeekSumsTable";
import LastWeekTransactionsTable from "../tables/Organization/LastWeekTransactionsTable";

interface TabPanelProps {
    children?: React.ReactNode;
    index: number;
    value: number;
}

function TabPanel(props: TabPanelProps) {
    const { children, value, index, ...other } = props;

    return (
        <div
            role="tabpanel"
            hidden={value !== index}
            id={`simple-tabpanel-${index}`}
            aria-labelledby={`simple-tab-${index}`}
            {...other}
        >
            {value === index && (
                <Box sx={{ p: 3 }}>
                    <Typography>{children}</Typography>
                </Box>
            )}
        </div>
    );
}

function a11yProps(index: number) {
    return {
        id: `simple-tab-${index}`,
        'aria-controls': `simple-tabpanel-${index}`,
    };
}

const OrganizationAccount: FC = (): ReactElement => {

    const {statisticsOrganization} = useContext(Context)
    const {auth} = useContext(Context)

    const [value, setValue] = React.useState(0);

    const handleChange = (event: React.SyntheticEvent, newValue: number) => {
        setValue(newValue);
    };

    useEffect(() => {
        statisticsOrganization.getLastWeekSum()
        statisticsOrganization.getLastWeekTransactions()
    }, [])

    return (
        statisticsOrganization.lastWeekSum &&
        statisticsOrganization.lastWeekTransactions &&

        <Box sx={{
            flexGrow: 1,
            backgroundColor: 'whitesmoke',
            display: 'flex',
            justifyContent: 'center'
        }}>
            <Container sx={{mt: 3, mb: 3}} maxWidth="md">
                <Typography variant="h3" sx={{mb: 3}}>{auth.user.account_title}</Typography>
                <Box sx={{ width: '100%', mb: 3 }}>
                    <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
                        <Tabs value={value}
                              textColor="secondary"
                              indicatorColor="secondary"
                              onChange={handleChange}
                              aria-label="basic tabs example">
                            <Tab label="Statistics" {...a11yProps(0)} />
                            <Tab label="Lots" {...a11yProps(1)} />
                        </Tabs>
                    </Box>
                </Box>
                <TabPanel value={value} index={0}>
                    <LastWeekSumsTable
                        lastWeekSum={statisticsOrganization.lastWeekSum}
                    />
                    <LastWeekTransactionsTable
                        lastWeekTransactions={statisticsOrganization.lastWeekTransactions}
                    />
                </TabPanel>
                <TabPanel value={value} index={1}>
                    Lots
                </TabPanel>
            </Container>
        </Box>
    );
};

export default observer(OrganizationAccount);