/*Detalle de Procedimientos*/
IF OBJECT_ID('USPROH','U') IS NOT NULL DROP TABLE USPROH
GO
CREATE TABLE [dbo].[USPROH](
	[ProcedimientoID] [varchar](30) NOT NULL,
	[ControlID] [varchar](100) NOT NULL,
    [DescripcionControl] [varchar](200) NOT NULL
)
GO
ALTER TABLE [dbo].[USPROH] ADD CONSTRAINT [USPROHProcedimientoIDControlID] PRIMARY KEY CLUSTERED ([ProcedimientoID] ASC, [ControlID] ASC)
GO
ALTER TABLE [dbo].[USPROH] ADD CONSTRAINT [USPROHProcedimientoID] FOREIGN KEY (ProcedimientoID) REFERENCES USPRO(ProcedimientoID)



