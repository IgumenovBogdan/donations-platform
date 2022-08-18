import React, { FC, ReactElement } from "react";
import {
    Box,
    Link,
    Container,
    IconButton,
    Menu,
    MenuItem,
    Toolbar,
    Typography, Button,
} from "@mui/material";
import MenuIcon from "@mui/icons-material/Menu";
import { navbarRoutes } from "../../../routes";
import { NavLink } from "react-router-dom";
import {observer} from "mobx-react-lite";
import NavbarRightButtons from "./NavbarRightButtons";

const Navbar: FC = (): ReactElement => {
    const [anchorElNav, setAnchorElNav] = React.useState(null);

    const handleOpenNavMenu = (event: any) => {
        setAnchorElNav(event.currentTarget);
    };

    const handleCloseNavMenu = () => {
        setAnchorElNav(null);
    };

    return (
        <Box
            sx={{
                width: "100%",
                height: "auto",
                backgroundColor: "primary.light",
            }}
        >
            <Container maxWidth="xl">
                <Toolbar disableGutters>
                    <Typography
                        variant="h6"
                        noWrap
                        sx={{
                            mr: 2,
                            display: { xs: "none", md: "flex" },
                        }}
                    >
                        DonationsUA
                    </Typography>
                    <Box sx={{ flexGrow: 1, display: { xs: "flex", md: "none" } }}>
                        <IconButton
                            size="large"
                            aria-label="account of current user"
                            aria-controls="menu-appbar"
                            aria-haspopup="true"
                            onClick={handleOpenNavMenu}
                            color="inherit"
                        >
                            <MenuIcon />
                        </IconButton>
                        <Menu
                            id="menu-appbar"
                            anchorEl={anchorElNav}
                            anchorOrigin={{
                                vertical: "bottom",
                                horizontal: "left",
                            }}
                            keepMounted
                            transformOrigin={{
                                vertical: "top",
                                horizontal: "left",
                            }}
                            open={Boolean(anchorElNav)}
                            onClose={handleCloseNavMenu}
                            sx={{
                                display: { xs: "block", md: "none" },
                            }}
                        >
                            {navbarRoutes.map((page) => (
                                <Link
                                    key={page.key}
                                    component={NavLink}
                                    to={page.path}
                                    color="black"
                                    underline="none"
                                    variant="button"
                                >
                                    <MenuItem onClick={handleCloseNavMenu}>
                                        <Typography textAlign="center">{page.title}</Typography>
                                    </MenuItem>
                                </Link>
                            ))}
                        </Menu>
                    </Box>
                    <Typography
                        variant="h6"
                        noWrap
                        component="div"
                        sx={{ flexGrow: 1, display: { xs: "flex", md: "none" } }}
                    >
                        DonationsUA
                    </Typography>
                    <Box sx={{ flexGrow: 1, display: { xs: "none", md: "flex" } }}>
                        <Box
                            sx={{
                                display: "flex",
                                flexDirection: "row",
                                justifyContent: "flex-start",
                                alignItems: "center",
                                marginLeft: "1rem",
                            }}
                        >
                            {navbarRoutes.map((page) => (
                                <Link
                                    key={page.key}
                                    component={NavLink}
                                    to={page.path}
                                    color="black"
                                    underline="none"
                                    variant="button"
                                    sx={{ fontSize: "large", marginLeft: "2rem" }}
                                >
                                    {page.title}
                                </Link>
                            ))}
                        </Box>
                    </Box>
                    <Box sx={{ flexGrow: 0 }}>
                        <NavbarRightButtons />
                    </Box>
                </Toolbar>
            </Container>
        </Box>
    );
};

export default observer(Navbar);