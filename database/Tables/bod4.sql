CREATE TABLE [dbo].[bod4] (
    [wip_number]   NVARCHAR (10)  NOT NULL,
    [registration] NVARCHAR (10)  NOT NULL,
    [description]  NVARCHAR (MAX) NOT NULL,
    [date_in]      NVARCHAR (10)  NOT NULL,
    [time_in]      NVARCHAR (10)  NOT NULL,
    [allowed_time] NVARCHAR (10)  NOT NULL,
    [light_heavy]  NVARCHAR (10)  NOT NULL,
    [technician]   NVARCHAR (10)  NOT NULL
);

