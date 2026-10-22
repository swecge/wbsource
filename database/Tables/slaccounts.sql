CREATE TABLE [dbo].[slaccounts]
(
	[ACCOUNT] [varchar](50) NULL,
	[CAT] [varchar](2) NULL
)
GO

CREATE NONCLUSTERED INDEX IX_SLACC
ON [dbo].[slaccounts] ([ACCOUNT])
INCLUDE ([CAT])
GO