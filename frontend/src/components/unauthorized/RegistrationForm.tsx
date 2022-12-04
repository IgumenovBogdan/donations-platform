import React, {FC, useContext, useState} from 'react';
import {Context} from "../../index";
import {observer} from "mobx-react-lite";
import {
    Accordion,
    AccordionDetails,
    AccordionSummary,
    Avatar,
    Box, Button,
    Typography
} from "@mui/material";
import {useNavigate} from "react-router-dom";
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import HowToRegIcon from '@mui/icons-material/HowToReg';
import OrganizationRegistrationForm from "../forms/OrganizationRegistrationForm";
import {IOrganization} from "../../models/IOrganization";
import ContributorRegistrationForm from "../forms/ContributorRegistrationForm";
import {IContributor} from "../../models/IContributor";
import useAlert from "../../hooks/useAlert";

const RegistrationForm: FC = () => {

    const {auth} = useContext(Context);

    const initialContributorState = {
        email: "",
        password: "",
        first_name: "",
        middle_name: "",
        last_name: ""
    };
    const [contributorState, setContributorState] = useState<IContributor>(initialContributorState);

    const initialOrganizationState = {
        email: "",
        password: "",
        name: "",
        description: "",
        phone: ""
    };
    const [organizationState, setOrganizationState] = useState<IOrganization>(initialOrganizationState);

    const updateOrganizationState = (state: any) => {
        setOrganizationState(state)
    }

    const updateContributorState = (state: any) => {
        setContributorState(state)
    }

    const navigate = useNavigate();

    const { setAlert } = useAlert();

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {

        if (registrationRole === 'organization') {
            auth.registerOrganization({...organizationState}).then(() => {
                if(auth.error) {
                    setAlert(auth.error, 'error');
                    auth.setError('');
                } else {
                    navigate('/')
                    setAlert('Registration success!', 'success');
                }
            });
        }

        if (registrationRole === 'contributor') {
            auth.registerContributor({...contributorState}).then(() => {
                if(auth.error) {
                    setAlert(auth.error, 'error');
                    auth.setError('');
                } else {
                    navigate('/')
                    setAlert('Registration success!', 'success');
                }
            });
        }

        e.preventDefault();

    }

    const [expanded, setExpanded] = React.useState<string | false>(false);
    const [registrationRole, setRegistrationRole] = useState('');

    const handleChange =
        (panel: string) => (event: React.SyntheticEvent, isExpanded: boolean) => {
            setExpanded(isExpanded ? panel : false);
        };

    const handleRoleChange = (role: string) => {
        setRegistrationRole(role);
    }

    return (
        <Box sx={{
            flexGrow: 1,
            backgroundColor: 'whitesmoke',
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center'
        }}>
            <Box
                component="form"
                onSubmit={handleSubmit}
                noValidate
                sx={{
                display: 'flex',
                flexDirection: 'column',
                alignItems: 'center',
                width: 500,
                mr: 2, ml: 2, mb: 5, mt: 5
            }}>
                <Avatar sx={{ m: 1, bgcolor: 'primary.light' }}>
                    <HowToRegIcon />
                </Avatar>
                <Typography component="h1" variant="h5" sx={{ mb: 1 }}>
                    Sign Up
                </Typography>
                <div>
                    <Typography
                        variant="h6"
                        sx={{
                            width: '50%',
                            flexShrink: 0,
                            mb: 1
                    }}>
                        Choose role:
                    </Typography>
                    <Accordion
                        expanded={expanded === 'panel1'}
                        onChange={handleChange('panel1')}
                        onClick={() => handleRoleChange('organization')}>
                        <AccordionSummary
                            expandIcon={<ExpandMoreIcon />}
                            aria-controls="panel1bh-content"
                            id="panel1bh-header"
                        >
                            <Typography sx={{ width: '33%', flexShrink: 0 }}>Organization</Typography>
                            <Typography sx={{ color: 'text.secondary' }}>
                                Create collection lots on behalf of your organization
                            </Typography>
                        </AccordionSummary>
                        <AccordionDetails>
                            <OrganizationRegistrationForm
                                initialState={initialOrganizationState}
                                updateData={updateOrganizationState}
                            />
                        </AccordionDetails>
                    </Accordion>
                    <Accordion
                        expanded={expanded === 'panel2'}
                        onChange={handleChange('panel2')}
                        onClick={() => handleRoleChange('contributor')}>
                        <AccordionSummary
                            expandIcon={<ExpandMoreIcon />}
                            aria-controls="panel2bh-content"
                            id="panel2bh-header"
                        >
                            <Typography sx={{ width: '33%', flexShrink: 0 }}>Contributor</Typography>
                            <Typography sx={{ color: 'text.secondary' }}>
                                Donate money to fundraisers that interest you
                            </Typography>
                        </AccordionSummary>
                        <AccordionDetails>
                            <ContributorRegistrationForm
                                initialState={initialContributorState}
                                updateData={updateContributorState}
                            />
                        </AccordionDetails>
                    </Accordion>
                </div>
                <Button
                    type="submit"
                    fullWidth
                    variant="contained"
                    sx={{ mt: 3, mb: 2 }}
                >
                    Sign Up
                </Button>
            </Box>
        </Box>
    );
};

export default observer(RegistrationForm);