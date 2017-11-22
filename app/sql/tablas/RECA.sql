/*Relacion Causal Novedad*/
IF OBJECT_ID('RECA','U') IS NOT NULL DROP TABLE RECA
GO
CREATE TABLE [dbo].[RECA](
	[NovedadID] [varchar](9) NOT NULL,
	[CausalID] [varchar](9) NOT NULL,
)
GO
ALTER TABLE [dbo].[RECA] ADD CONSTRAINT [RECANovedadIDCausalID] PRIMARY KEY CLUSTERED ([NovedadID] ASC, [CausalID] ASC)
GO

