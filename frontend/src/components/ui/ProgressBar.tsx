import React from "react";


import { lighten, Box, LinearProgress, Typography } from "@mui/material";
import {withStyles} from "@material-ui/styles";

interface Props {
    color?: "primary" | "secondary";
    hex?: string;
    value?: number;
}

/**
 * ProgressBar -- atom
 * A material-ui progress bar.
 * @param {'primary' | 'secondary'} color Choose to render the primary or secondary colors.
 * @param {string} hex Override the selected color with a hex value.
 * @param {number} value The value for the progress bar, between 0-100.
 * @return {JSX} React component
 */
const ProgressBar = ({ color, hex, value }: Props) => {
    let internalColor: string;

    if (typeof hex === "undefined") {
        internalColor = "#3f51b5";
    } else if (typeof hex !== "undefined" && /^#[0-9A-F]{6}$/i.test(hex)) {
        internalColor = hex;
    } else {
        throw new Error("Invalid hex prop -- please use a hex string.");
    }

    if (typeof value === "undefined") {
        value = 0;
    } else if (typeof value === "number" && value < 0) {
        throw new Error(
            "Invalid value prop -- please use a number more than or equal to 0."
        );
    } else if (typeof value === "number" && value > 100) {
        throw new Error(
            "Invalid value prop -- please use a number less than or equal to 100."
        );
    }

    // from: https://bit.dev/mui-org/material-ui/linear-progress
    const BorderLinearProgress = withStyles({
        root: {
            height: 20,
            width: "100%",
            backgroundColor: hex ? lighten(internalColor, 0.5) : undefined,
            borderRadius: "10px"
        },
        bar: {
            borderRadius: 20,
            backgroundColor: hex ? internalColor : undefined
        }
    })(LinearProgress);

    // from: https://stackoverflow.com/a/60609045/14198287
    const WhiteTextTypography = withStyles({
        root: {
            color: "#FFFFFF"
        }
    })(Typography);

    return (
        <Box position="relative" display="inline-flex" style={{ width: "100%" }}>
            <BorderLinearProgress
                color={hex ? undefined : color}
                variant="determinate"
                value={value}
            />
            <Box
                top={0}
                left={0}
                bottom={0}
                right={0}
                position="absolute"
                display="flex"
                alignItems="center"
                justifyContent="center"
            >
                <WhiteTextTypography variant="body2">{`${value}%`}</WhiteTextTypography>
            </Box>
        </Box>
    );
};

export default ProgressBar;